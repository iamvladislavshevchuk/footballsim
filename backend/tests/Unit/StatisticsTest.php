<?php

namespace Tests\Unit;

use App\Models\Simulation;
use App\Models\Team;
use App\Services\StatisticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_statistics_works_correctly()
    {
        $service = new StatisticsService();

        $simulation = Simulation::create();
        $chelsea = Team::factory()->for($simulation)->create();
        $manchester = Team::factory()->for($simulation)->create();
        
        $games = collect([]);

        $games[] = $simulation->games()->create([
            'home_id' => $chelsea->id,
            'away_id' => $manchester->id,
            'home_score' => 3,
            'away_score' => 1,
            'week' => 1
        ]);

        $games[] = $simulation->games()->create([
            'home_id' => $manchester->id,
            'away_id' => $chelsea->id,
            'home_score' => 1,
            'away_score' => 2,
            'week' => 2
        ]);

        $leaderboard = $service->leaderboard($games);
        $winner = $service->winner($games);
        $chelseaStats = $leaderboard->first(fn($item) => $item['team']['id'] === $chelsea->id);
        $manchesterStats = $leaderboard->first(fn($item) => $item['team']['id'] === $manchester->id);

        $this->assertTrue($winner['team']['id'] === $chelsea->id, 'Chelsea should be a winner based on PTS');
        $this->assertTrue($chelseaStats['team']['id'] === $chelsea->id, 'Stats should have a team\'s id');
        $this->assertTrue($chelseaStats['PTS'] === 6, 'Chelsea should\'ve gained 6 points, but it gained '.$chelseaStats['PTS'].' points');
        $this->assertTrue($chelseaStats['W'] === 2, 'Chelsea should\'ve won 2 games, but it won '.$chelseaStats['W'].' games');
        $this->assertTrue($chelseaStats['D'] === 0, 'Chelsea should\'ve drawn 0 games, but it drawn '.$chelseaStats['D'].' games');
        $this->assertTrue($chelseaStats['L'] === 0, 'Chelsea should\'ve lost 0 games, but it lost '.$chelseaStats['L'].' games');
        $this->assertTrue($chelseaStats['P'] === 2, 'Chelsea should\'ve played 2 games, but it played '.$chelseaStats['P'].' games');
        $this->assertTrue($chelseaStats['GD'] === 3, 'Chelsea should\'ve had 3 GD, but it has '.$chelseaStats['GD'].' GD');
        $this->assertTrue($manchesterStats['PTS'] === 0, 'Manchester should\'ve gained 0 points, but it gained '.$chelseaStats['PTS'].' points');
        $this->assertTrue($manchesterStats['W'] === 0, 'Manchester should\'ve won 0 games, but it won '.$chelseaStats['W'].' games');
        $this->assertTrue($manchesterStats['D'] === 0, 'Manchester should\'ve drawn 0 games, but it drawn '.$chelseaStats['D'].' games');
        $this->assertTrue($manchesterStats['L'] === 2, 'Manchester should\'ve lost 2 games, but it lost '.$chelseaStats['L'].' games');
        $this->assertTrue($manchesterStats['P'] === 2, 'Manchester should\'ve played 2 games, but it played '.$chelseaStats['P'].' games');
        $this->assertTrue($manchesterStats['GD'] === -3, 'Manchester should\'ve had -3 GD, but it has '.$chelseaStats['GD'].' GD');
    }

    public function test_goal_difference_is_taken_into_account_when_choosing_winner()
    {
        $service = new StatisticsService();

        $simulation = Simulation::create();
        $chelsea = Team::factory()->for($simulation)->create();
        $manchester = Team::factory()->for($simulation)->create();
        $arsenal = Team::factory()->for($simulation)->create();

        $games = collect([]);

        $games[] = $simulation->games()->create([
            'home_id' => $chelsea->id,
            'away_id' => $manchester->id,
            'home_score' => 0,
            'away_score' => 0,
            'week' => 1
        ]);

        $games[] = $simulation->games()->create([
            'home_id' => $manchester->id,
            'away_id' => $chelsea->id,
            'home_score' => 0,
            'away_score' => 0,
            'week' => 2
        ]);

        $games[] = $simulation->games()->create([
            'home_id' => $arsenal->id,
            'away_id' => $chelsea->id,
            'home_score' => 0,
            'away_score' => 2,
            'week' => 3
        ]);

        $games[] = $simulation->games()->create([
            'home_id' => $arsenal->id,
            'away_id' => $manchester->id,
            'home_score' => 0,
            'away_score' => 3,
            'week' => 4
        ]);

        $winner = $service->winner($games);
        $this->assertTrue($winner['team']['id'] === $manchester->id, 'Manchester should be a winner based on GD');
    }
}
