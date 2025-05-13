<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoardgameResource;
use App\Http\Resources\TopBoardgameByAssociationsResource;
use App\Http\Resources\TopBoardgameByUsersResource;
use App\Models\Association;
use App\Models\Boardgame;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GameStatsController extends Controller
{
    /**
     * Get the boardgame with the most games.
     */
    public function topBoardgame()
    {
        // Get the boardgame with the most games.
        $game = Game::getTopBoardgamePlayed();

        // Returning spot.
        return response()->json([
            'data' => [
                'boardgame' => new BoardgameResource($game),
                'games_count' => $game->games_count,
            ]
        ]);
    }

    /**
     * Get the boardgame with the most games by association.
     */
    public function topBoardgamesByAssociations()
    {
        // Returning spot.
        return Game::getTopBoardgamePlayedByAssociations(); // resources only on models
    }

    /**
     * Get the boardgame with the most games by user.
     */
    public function topBoardgamesByUsers()
    {
        // Returning spot.
        return TopBoardgameByUsersResource::collection(Game::getTopBoardgamePlayedByUsers()); // resources only on models
    }
}
