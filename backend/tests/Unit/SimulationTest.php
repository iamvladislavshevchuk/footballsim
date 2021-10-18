<?php

namespace Tests\Unit;

use App\Models\Simulation;
use App\Models\Team;
use App\Services\GameSimulationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_game_simulation_returns_array_with_integers()
    {
        $simulation = Simulation::create();
        $home = Team::factory()->for($simulation)->create();
        $away = Team::factory()->for($simulation)->create();

        $service = new GameSimulationService($home, $away);
        $result = $service->simulate();

        $this->assertTrue(count($result) === 2, 'The result must contain two elements. It contains '.count($result).' elements.');
        $this->assertTrue(gettype($result[0]) === 'integer', 'The first element must be an integer.');
        $this->assertTrue(gettype($result[1]) === 'integer', 'The second element must be an integer.');
    }
}
