<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopBoardgameByAssociationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'association' => new AssociationResource($this->association),
            'boardgame' => new BoardgameResource($this->boardgame),
            'games_count' => $this->games_count,
        ];
    }
}
