<?php

namespace Tests\Unit;

use App\Models\Simulation;
use App\Models\Team;
use App\Services\GameSimulation\SimpleGameSimulationService;
use App\Services\GameSimulationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimpleGameSimulationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_game_simulation_returns_array_with_integers()
    {
        $service = new SimpleGameSimulationService();

        $simulation = Simulation::create();
        $home = Team::factory()->for($simulation)->create();
        $away = Team::factory()->for($simulation)->create();
        $result = $service->simulate($home, $away);

        $this->assertTrue(count($result) === 2, 'The result must contain two elements. It contains '.count($result).' elements.');
        $this->assertTrue(gettype($result[0]) === 'integer', 'The first element must be an integer.');
        $this->assertTrue(gettype($result[1]) === 'integer', 'The second element must be an integer.');
    }
}
