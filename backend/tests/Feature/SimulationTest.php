<?php

namespace Tests\Feature;

use App\Models\DefaultTeam;
use App\Models\Game;
use App\Models\Simulation;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulationTest extends TestCase
{
    use RefreshDatabase;

    public function test_simulation_creates_fixture_on_store()
    {
        DefaultTeam::factory()->count(4)->create();

        $this->postJson('/simulations')->assertSuccessful();

        $count = Game::count();
        $this->assertTrue($count === 12, 'Four teams should\'ve had 12 games, but they had '.$count.' games.');
    }

    public function test_user_can_simulate_week()
    {
        $simulation = Simulation::create();
        Team::factory()->count(4)->for($simulation)->create();
        $simulation->generateFixture();

        $this->patchJson('/simulations/'.$simulation->id.'/week', ['week' => 1])->assertSuccessful();

        $count = $simulation->games()->week(1)->empty()->count();
        $this->assertTrue($count === 0, 'All games in the week should be simulated, but '.$count.' were left untouched');
    }

    public function test_user_can_simulate_season()
    {
        $simulation = Simulation::create();
        Team::factory()->count(4)->for($simulation)->create();
        $simulation->generateFixture();

        $this->patchJson('/simulations/'.$simulation->id.'/season')->assertSuccessful();

        $count = $simulation->games()->empty()->count();
        $this->assertTrue($count === 0, 'All games in the season should be simulated, but '.$count.' were left untouched');
    }
}
