<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'boardgame_id' => $this->boardgame_id,
            'association_id' => $this->association_id,
            'boardgame' => new BoardgameResource($this->boardgame),
            'association' => new AssociationResource($this->association),
            'users' => UserResource::collection($this->users),
        ];
    }
}
