<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Models\DefaultTeam;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DefaultTeamController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $teams = DefaultTeam::get();
        return TeamResource::collection($teams);
    }
}
