<?php

namespace App\Models;

use App\Services\FixtureService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Simulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'week'
    ];

    public function games(): Relation
    {
        return $this->hasMany(Game::class);
    }

    public function teams(): Relation
    {
        return $this->hasMany(Team::class);
    }

    public function generateTeams(): void
    {
        $default = DefaultTeam::get();

        $simulation = $this;
        $teams = $default->map(function($item) use ($simulation) {
            unset($item['created_at']);
            unset($item['updated_at']);
            $item['simulation_id'] = $simulation->id;
            return $item;
        })->toArray();

        Team::insert($teams);
    }

    public function generateFixture(): void
    {
        $fixture = new FixtureService();
        $games = $fixture->generate($this->teams)->map(function($item) {
            $item['simulation_id'] = $this->id;
            return $item;
        })->toArray();

        Game::insert($games);
    }

    public function getFinishedAttribute(): bool
    {
        return $this->games()->week($this->week + 1)->doesntExist();
    }

    public function getLastWeekAttribute(): int
    {
        return $this->games()->max('week');
    }
}
