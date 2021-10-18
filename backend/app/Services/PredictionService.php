<?php

namespace App\Services;

use App\Exceptions\PredictionNotPossibleException;
use App\Http\Resources\TeamResource;
use App\Models\Simulation;
use Illuminate\Support\Collection;

/**
 * Predicts the results of not simulated games.
 */
class PredictionService {
    public Simulation $simulation;

    public function __construct(Simulation $simulation) {
        $this->simulation = $simulation;
    }

    public function predict(): array
    {
        if (! $this->simulation->games()->exists())
            throw new PredictionNotPossibleException('Simulation doesn\'t contain games.');

        $games = $this->simulation->games()->simulated()->get();
        $empty = $this->simulation->games()->empty()->get();
        return $this->predictBySimulation($games, $empty, 100);
    }

    /**
     * Predicts the outcome using the same simulation.
     */
    protected function predictBySimulation(Collection $games, Collection $empty, int $n): array
    {
        $frequency = [];
        
        for ($i = 0; $i < $n; $i++) {
            $winner = $this->simulate($games, $empty);
            $frequency[] = $winner;
        }

        $teams = array_count_values($frequency);

        return $this->format($teams, $n);
    }

    /**
     * Simulates the empty games and returns the winner of the simulation.
     */
    public function simulate(Collection $games, Collection $empty): int
    {
        $simulated = collect([]);

        $empty->loadMissing('away', 'home');
        foreach ($empty as $game) {
            $service = new GameSimulationService($game->home, $game->away);
            [$home_score, $away_score] = $service->simulate();
            $game->home_score = $home_score;
            $game->away_score = $away_score;
            $simulated->push($game);
        }

        $total = $games->merge($simulated);
        $statistics = new StatisticsService($total);
        return $statistics->winner()['team']['id'];
    }

    protected function format(array $frequency, int $n): array
    {
        $result = [];

        foreach ($this->simulation->teams as $team) {
            $result[] = [
                'team' => new TeamResource($team),
                'chance' => (double) ($frequency[$team->id] ?? 0) / $n
            ];
        }

        return $result;
    }
}