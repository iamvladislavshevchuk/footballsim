<?php

namespace App\Interfaces;

use App\Models\Simulation;

interface PredictionInterface 
{
    public function predict(Simulation $simulation): array;
}