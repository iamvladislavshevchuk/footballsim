<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'strength'
    ];

    public function games(): Relation
    {
        return $this->hasMany(Game::class);
    }

    public function simulation(): Relation
    {
        return $this->belongsTo(Simulation::class);
    }
}
