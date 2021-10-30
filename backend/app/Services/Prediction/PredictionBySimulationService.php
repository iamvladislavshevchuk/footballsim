<?php

namespace App\Services\Prediction;

use App\Exceptions\PredictionNotPossibleException;
use App\Http\Resources\TeamResource;
use App\Interfaces\GameSimulationInterface;
use App\Interfaces\PredictionInterface;
use App\Models\Simulation;
use App\Services\StatisticsService;
use Illuminate\Support\Collection;

/**
 * Predicts the results of not simulated games.
 */
class PredictionBySimulationService implements PredictionInterface 
{
    protected GameSimulationInterface $simulator;
    protected StatisticsService $statistics;

    public function __construct(GameSimulationInterface $simulator, StatisticsService $statistics) 
    {
        $this->simulator = $simulator;
        $this->statistics = $statistics;
    }

    public function predict(Simulation $simulation): array
    {
        if (! $simulation->games()->exists())
            throw new PredictionNotPossibleException('Simulation doesn\'t contain games.');

        $n = 100;
        $games = $simulation->games()->simulated()->get();
        $empty = $simulation->games()->empty()->get();

        $prediction = $this->predictBySimulation($games, $empty, $n);
        return $this->format($simulation, $prediction, $n);
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

        return array_count_values($frequency);
    }

    /**
     * Simulates the empty games and returns the winner of the simulation.
     */
    protected function simulate(Collection $games, Collection $empty): int
    {
        $simulated = collect([]);

        $empty->loadMissing('away', 'home');
        foreach ($empty as $game) {
            [$home_score, $away_score] = $this->simulator->simulate($game->home, $game->away);
            $game->home_score = $home_score;
            $game->away_score = $away_score;
            $simulated->push($game);
        }

        $total = $games->merge($simulated);
        return $this->statistics->winner($total)['team']['id'];
    }

    protected function format(Simulation $simulation, array $frequency, int $n): array
    {
        $result = [];

        foreach ($simulation->teams as $team) {
            $result[] = [
                'team' => new TeamResource($team),
                'chance' => (double) ($frequency[$team->id] ?? 0) / $n
            ];
        }

        return $result;
    }
}