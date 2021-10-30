<?php

namespace App\Services\Fixture;

use App\Models\Team;
use App\Interfaces\FixtureInterface;
use Illuminate\Support\Collection;

/**
 * Creates a fixture for any number of teams.
 */
class RoundRobinFixtureService implements FixtureInterface 
{
    /**
     * @param \Illuminate\Database\Eloquent\Collection<mixed, Team> $teams
     */
    public function generate($teams): Collection
    {
        $half = $this->matchups($teams);
        $reversed = $this->reverse($half);
        return $half->merge($reversed);
    }

    /**
     * Finds matchups using round-robin algorythm.
     */
    protected function matchups(Collection $teams)
    {
        $result = collect([]);
        $teams = $teams->toBase();

        if ($teams->count() % 2 !== 0) {
            $teams->push(null);
        }

        $week = 1;
        $old = $teams[1]->id ?? null;
        $middle = $teams->count() / 2;
        while (true) {
            for ($i = 0; $i < $middle; $i++) {
                $home = $teams[$i];
                $away = $teams[$i + $middle];

                if (!$home || !$away)
                    continue;

                $result->push([
                    'home_id' => $home->id,
                    'away_id' => $away->id,
                    'week' => $week
                ]);
            }

            $chunk = $teams->splice(1);
            $chunk = $chunk->rotate(1);
            $teams = $teams->merge($chunk);

            // breaks the cycle when collection returns to the initial position
            $new = $teams[1]->id ?? null;
            if ($old === $new)
                break;

            $week++;
        }

        return $result;
    }

    /**
     * Reverses the initial matchup.
     * Changes a home team with an away team and a date.
     */
    protected function reverse(Collection $teams)
    {
        $max = $teams->map(fn($item) => $item['week'])->max();

        return $teams->map(function($item) use ($max) {
            $result = $item;
            $result['home_id'] = $item['away_id'];
            $result['away_id'] = $item['home_id'];
            $result['week'] = $item['week'] + $max;
            return $result;
        });
    }
}