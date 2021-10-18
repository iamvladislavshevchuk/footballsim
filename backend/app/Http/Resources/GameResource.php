<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'home' => new TeamResource($this->home),
            'away' => new TeamResource($this->away),
            'home_score' => $this->home_score,
            'away_score' => $this->away_score,
            'week' => $this->week
        ];
    }
}
