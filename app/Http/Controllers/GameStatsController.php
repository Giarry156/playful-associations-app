<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssociationResource;
use App\Http\Resources\BoardgameResource;
use App\Http\Resources\GenericResponseDataCollection;
use App\Http\Resources\UserResource;
use App\Models\Association;
use App\Models\Boardgame;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameStatsController extends Controller
{
    public function topBoardgame(){
        // Get the boardgame with the most games.
        $game = Boardgame::withCount('games')
            ->orderBy('games_count', 'desc')
            ->first();

        // Formatting result.
        $topGame = [
            'boardgame' => new BoardgameResource($game),
            'games_count' => $game->games_count,
        ];

        // Returning spot.
        return new GenericResponseDataCollection($topGame);
    }

    public function topBoardgamesByAssociations(){
        // Retrieving all games grouped by association and boardgame.
        $games = DB::table('games')
            ->select('association_id', 'boardgame_id', DB::raw('count(*) as games_count'))
            ->groupBy('association_id', 'boardgame_id')
            ->orderBy('association_id')
            ->get();

        // Formatting result.
        $topPerAssociation = $games
            ->groupBy('association_id')
            ->map(function ($rows, $associationId) {
                // Retrieving the top game for each association.
                $topGame = $rows->sortByDesc('games_count')->first();

                // Retrieving the association and boardgame.
                $association = Association::find($associationId);
                $boardgame = Boardgame::find($topGame->boardgame_id);

                // Returning formatted data.
                return [
                    'association' => new AssociationResource($association),
                    'boardgame' => new BoardgameResource($boardgame),
                    'games_count' => $topGame->games_count,
                ];
            })
            ->values();

        // Returning spot.
        return new GenericResponseDataCollection($topPerAssociation);
    }

    public function topBoardgamesByUsers(){
        // Retrieving all games grouped by user and boardgame.
        $games = DB::table('games')
            ->join('game_user', 'games.id', '=', 'game_user.game_id')
            ->select('game_user.user_id', 'games.boardgame_id', DB::raw('count(*) as games_count'))
            ->groupBy('game_user.user_id', 'games.boardgame_id')
            ->orderBy('game_user.user_id')
            ->get();

        // Formatting result.
        $topPerUser = $games
            ->groupBy('user_id')
            ->map(function ($rows, $userId) {
                // Retrieving the top game for each user.
                $topGame = $rows->sortByDesc('games_count')->first();

                // Retrieving the user and boardgame.
                $user = User::find($userId);
                $boardgame = Boardgame::find($topGame->boardgame_id);

                // Returning formatted data.
                return [
                    'user' => new UserResource($user),
                    'boardgame' => new BoardgameResource($boardgame),
                    'games_count' => $topGame->games_count,
                ];
            })
            ->values();

        // Returning spot.
        return new GenericResponseDataCollection($topPerUser);
    }
}
