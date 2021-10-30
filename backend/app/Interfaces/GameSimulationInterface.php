<?php

namespace App\Interfaces;

use App\Models\Team;

interface GameSimulationInterface 
{
    public function simulate(Team $home, Team $away): array;
}