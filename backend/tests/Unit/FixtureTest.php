<?php

namespace Tests\Unit;

use App\Models\Simulation;
use App\Models\Team;
use App\Services\FixtureService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FixtureTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_fixture_returns_correct_data()
    {
        $fixture = $this->makeFixture(4);
        $this->assertGamesCount($fixture, 12);
        $this->assertWeeksCount($fixture, 6);

        $fixture = $this->makeFixture(3);
        $this->assertGamesCount($fixture, 6);
        $this->assertWeeksCount($fixture, 6);

        $fixture = $this->makeFixture(7);
        $this->assertGamesCount($fixture, 42);
        $this->assertWeeksCount($fixture, 14);

        $fixture = $this->makeFixture(10);
        $this->assertGamesCount($fixture, 90);
        $this->assertWeeksCount($fixture, 18);

        $fixture = $this->makeFixture(20);
        $this->assertGamesCount($fixture, 380);
        $this->assertWeeksCount($fixture, 38);
    }

    protected function makeFixture(int $teamsCount)
    {
        $simulation = Simulation::create();
        $teams = Team::factory()->for($simulation)->count($teamsCount)->create();
        return (new FixtureService())->generate($teams);
    }

    protected function assertGamesCount(Collection $fixture, int $expected)
    {
        $count = count($fixture);
        $this->assertTrue($count === $expected, 'Twenty teams should\'ve played '.$expected.' games, but they played '.$count.' games.');
    }

    protected function assertWeeksCount(Collection $fixture, int $expected)
    {
        $count = $fixture->map(fn($item) => $item['week'])->max();
        $this->assertTrue($count === $expected, 'Twenty teams should\'ve played '.$expected.' weeks, but they played '.$count.' weeks.');
    }
}
