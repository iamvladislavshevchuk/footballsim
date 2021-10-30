<?php

namespace App\Http\Controllers;

use App\Http\Resources\SimulationResource;
use App\Models\Simulation;
use Illuminate\Http\Request;

class SimulationSeasonController extends Controller
{
    public function update(Request $request, Simulation $simulation): SimulationResource
    {
        $games = $simulation->games()->empty()->with('home', 'away')->get();

        foreach ($games as $game)
            $game->simulate();

        $simulation->update(['week' => $simulation->last_week]);
        $simulation->loadMissing('games.home', 'games.away');
        return new SimulationResource($simulation);
    }
}
