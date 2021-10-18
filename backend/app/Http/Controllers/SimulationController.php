<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulationStoreRequest;
use App\Http\Requests\SimulationWeekRequest;
use App\Http\Resources\SimulationResource;
use App\Models\Simulation;

class SimulationController extends Controller
{
    /**
     * This method creates a simulation.
     * For now, it only creates default teams and a fixture to it.
     * But it's very easy to extend the code to allow the user to create a couple of simulations with different teams.
     * That's why this method is made this way.
     */
    public function store(SimulationStoreRequest $request): SimulationResource
    {
        $simulation = Simulation::create();
        $simulation->generateTeams();
        $simulation->generateFixture();
        
        $simulation->loadMissing('games.home', 'games.away');
        return new SimulationResource($simulation);
    }

    public function show(): SimulationResource
    {
        $simulation = Simulation::first();
        abort_if(! $simulation, 404);

        $simulation->loadMissing('games.home', 'games.away');
        return new SimulationResource($simulation);
    }

    public function destroy(Simulation $simulation): void
    {
        $simulation->delete();
    }

    /**
     * Simulates games of the given week.
     */
    public function week(SimulationWeekRequest $request, Simulation $simulation): SimulationResource
    {
        $games = $simulation->games()->week($request->week)->with('home', 'away')->get();

        foreach ($games as $game)
            $game->simulate();

        $simulation->update(['week' => $request->week]);

        $simulation->loadMissing('games.home', 'games.away');
        return new SimulationResource($simulation);
    }

    /**
     * Simulates games of the whole season.
     */
    public function season(Simulation $simulation): SimulationResource
    {
        $games = $simulation->games()->empty()->with('home', 'away')->get();

        foreach ($games as $game)
            $game->simulate();

        $simulation->update(['week' => $simulation->last_week]);
        $simulation->loadMissing('games.home', 'games.away');
        return new SimulationResource($simulation);
    }
}
