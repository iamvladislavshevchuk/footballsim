<?php

namespace App\Http\Controllers;

use App\Http\Requests\PredictionShowRequest;
use App\Interfaces\PredictionInterface;
use App\Models\Simulation;

class SimulationPredictionController extends Controller
{
    public function show(PredictionShowRequest $request, Simulation $simulation, PredictionInterface $service)
    {
        return $service->predict($simulation);
    }
}