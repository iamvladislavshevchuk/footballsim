<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulationWeekUpdateRequest;
use App\Http\Resources\SimulationResource;
use App\Models\Simulation;

class SimulationWeekController extends Controller
{
    public function update(SimulationWeekUpdateRequest $request, Simulation $simulation): SimulationResource
    {
        $games = $simulation->games()->week($request->week)->with('home', 'away')->get();

        foreach ($games as $game)
            $game->simulate();

        $simulation->update(['week' => $request->week]);
        $simulation->loadMissing('games.home', 'games.away');
        return new SimulationResource($simulation);
    }
}
