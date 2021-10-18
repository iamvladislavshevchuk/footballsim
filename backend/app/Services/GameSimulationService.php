<?php

namespace App\Services;

use App\Models\Team;

/**
 * Simulates the game between two teams.
 */
class GameSimulationService {
    public Team $home;
    public Team $away;

    public function __construct(Team $home, Team $away)
    {
        $this->home = $home;
        $this->away = $away;
    }
    
    public function simulate(): array
    {
        $total = $this->calcTotalScore();
        $scored = $this->calcHomeTeamScore($total);
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
    protected function calcHomeTeamScore(int $total): int
    {
        $result = 0;
        $strength = $this->home->strength / $this->away->strength;

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