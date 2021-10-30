<?php

namespace App\Services\GameSimulation;

use App\Models\Team;
use App\Interfaces\GameSimulationInterface;

/**
 * Simulates the game between two teams.
 */
class SimpleGameSimulationService implements GameSimulationInterface 
{
    public function simulate(Team $home, Team $away): array
    {
        $total = $this->calcTotalScore();
        $scored = $this->calcHomeTeamScore($home, $away, $total);
        $missed = $total - $scored;
        return [$scored, $missed];
    }

    /**
     * Calculates how many goals will be played in a game.
     */
    protected function calcTotalScore(): int
    {
        return rand(0, 6);
    }

    /**
     * Calculates how many goals the home team will score based on its strength.
     */
    protected function calcHomeTeamScore(Team $home, Team $away, int $total): int
    {
        $result = 0;
        $strength = $home->strength / $away->strength;  // 8 / 4 = 2

        // We assume every attack ends with a goal. 
        // If a home team doesn't score, an away team scores.
        for ($i = 0; $i < $total; $i++) {
            $result += (int) $this->isSuccessfulAttack($strength);
        }

        return $result;
    }

    /**
     * Decides if the attack was successful based on its strength.
     */
    protected function isSuccessfulAttack(float $strength): bool
    {
        $probabilty = rand(0, 10);
        $success = $probabilty * $strength;
        return $success >= 5;
    }
}