<?php

namespace Tests\Feature;

use App\Models\DefaultTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefaultTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_default_teams()
    {
        DefaultTeam::factory()->count(4)->create();

        $this->getJson('/teams/default')
            ->assertSuccessful()
            ->assertJsonCount(4);
    }
}
