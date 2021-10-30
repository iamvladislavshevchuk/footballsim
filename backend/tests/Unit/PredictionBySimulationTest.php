<?php

namespace Tests\Unit;

use App\Models\Simulation;
use App\Models\Team;
use App\Services\GameSimulation\SimpleGameSimulationService;
use App\Services\Prediction\PredictionBySimulationService;
use App\Services\StatisticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PredictionBySimulationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_prediction_service_returns_array_with_floats()
    {
        $service = new PredictionBySimulationService(
            new SimpleGameSimulationService(), 
            new StatisticsService()
        );

        $simulation = Simulation::create();
        Team::factory()->for($simulation)->count(4)->create();
        $simulation->generateFixture();
        $prediction = $service->predict($simulation);
        
        $this->assertTrue(count($prediction) > 0, 'The service should return at least one prediction');

        $value = $prediction[0]['chance'];
        $type = gettype($value);
        $this->assertTrue($type === 'double', 'The prediction for a team should be float. Instead, it\'s '.gettype($type).': '.$value);
    }
}
