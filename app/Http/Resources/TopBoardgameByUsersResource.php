<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopBoardgameByUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'boardgame' => new BoardgameResource($this->boardgame),
            'games_count' => $this->games_count,
        ];
    }
}
