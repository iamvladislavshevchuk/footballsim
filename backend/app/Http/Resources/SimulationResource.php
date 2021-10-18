<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimulationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'week' => $this->week,
            'games' => GameResource::collection($this->games),
            'finished' => $this->finished,
            'last_week' => $this->last_week
        ];
    }
}
