<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulationStatisticsShowRequest;
use App\Models\Simulation;
use App\Services\StatisticsService;
use Illuminate\Support\Collection;

class SimulationStatisticsController extends Controller
{
    public function show(SimulationStatisticsShowRequest $request, Simulation $simulation, StatisticsService $statistics): Collection
    {
        $games = $simulation->games()->where('week', '<=', $request->week)->get();
        return $statistics->leaderboard($games);
    }
}