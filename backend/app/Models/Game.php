<?php

namespace App\Models;

use App\Interfaces\GameSimulationInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_id',
        'away_id',
        'home_score',
        'away_score',
        'week'
    ];

    public function home(): Relation
    {
        return $this->belongsTo(Team::class, 'home_id', 'id');
    }

    public function away(): Relation
    {
        return $this->belongsTo(Team::class, 'away_id', 'id');
    }

    public function simulate(): void
    {
        $service = app()->make(GameSimulationInterface::class);

        [$home_score, $away_score] = $service->simulate($this->home, $this->away);

        $this->update([
            'home_score' => $home_score, 
            'away_score' => $away_score
        ]);
    }

    public function simulation($query, Simulation $simulation): void
    {
        $query->where('simulation_id', $simulation->id);
    }

    public function scopeSimulated($query): void
    {
        $query->whereNotNull('home_score')->whereNotNull('away_score');
    }

    public function scopeWeek($query, int $week): void
    {
        $query->where('week', $week);
    }

    /**
     * Returns games that are not simulated yet.
     */
    public function scopeEmpty($query): void
    {
        $query->whereNull('home_score')->orWhereNull('away_score');
    }
}
