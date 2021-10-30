<?php

namespace App\Interfaces;

use App\Models\Team;
use Illuminate\Support\Collection;

interface FixtureInterface 
{
    /**
     * @param \Illuminate\Database\Eloquent\Collection<mixed, Team> $teams
     */
    public function generate($teams): Collection;
}