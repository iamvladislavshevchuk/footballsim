<?php

namespace App\Http\Controllers;

use App\Http\Requests\PredictionShowRequest;
use App\Models\Simulation;
use App\Services\PredictionService;

class SimulationPredictionController extends Controller
{
    public function show(PredictionShowRequest $request, Simulation $simulation)
    {
        $service = new PredictionService($simulation);
        return $service->predict();
    }
}