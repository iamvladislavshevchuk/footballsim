<?php

namespace App\Services;

use App\Constants\Points;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\Game;
use Illuminate\Support\Collection;

/**
 * Gathers the statistics based on matches.
 */
class StatisticsService
{    
    /**
     * @param \Illuminate\Database\Eloquent\Collection<mixed, Game> $games
     */
    public function leaderboard($games): Collection
    {
        $result = collect([]);

        foreach ($games as $game) {
            $home = $game->home_id;
            $away = $game->away_id;

            if (! $result->get($home))
                $result->put($home, $this->statistics($home));

            if (! $result->get($away))
                $result->put($away, $this->statistics($away));

            $diff = $game->home_score - $game->away_score;

            if ($diff > 0) {
                $result[$home] = $this->won($result[$home], $diff);
                $result[$away] = $this->lost($result[$away], $diff);
            } else if ($diff === 0) {
                $result[$home] = $this->draw($result[$home]);
                $result[$away] = $this->draw($result[$away]);
            } else {
                $result[$home] = $this->lost($result[$home], -$diff);
                $result[$away] = $this->won($result[$away], -$diff);
            }
        }

        return $result->sortByDesc(function($team) {
            return [$team['PTS'], $team['GD']];
        })->values();
    }

    public function winner($games): array
    {
        return $this->leaderboard($games)->first();
    }

    /**
     * Returns the default statistics table.
     */
    protected function statistics(int $id): array
    {
        $team = new TeamResource(Team::find($id));

        return [
            'team' => $team,
            'PTS' => 0,
            'P' => 0,
            'W' => 0,
            'D' => 0,
            'L' => 0,
            'GD' => 0
        ];
    }

    protected function won(array $statistics, int $diff): array
    {
        $statistics['PTS'] += Points::WIN;
        $statistics['P'] += 1;
        $statistics['W'] += 1;
        $statistics['GD'] += $diff;
        return $statistics;
    }

    protected function lost(array $statistics, int $diff): array
    {
        $statistics['P'] += 1;
        $statistics['L'] += 1;
        $statistics['GD'] -= $diff;
        return $statistics;
    }

    public function draw(array $statistics): array
    {
        $statistics['PTS'] += Points::DRAW;
        $statistics['P'] += 1;
        $statistics['D'] += 1;
        return $statistics;
    }
}