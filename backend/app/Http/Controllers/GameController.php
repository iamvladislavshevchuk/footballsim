<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameUpdateRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;

class GameController extends Controller
{
    public function update(GameUpdateRequest $request, Game $game): GameResource
    {
        $game->update($request->validated());
        return new GameResource($game);
    }
}
