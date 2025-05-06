<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoardgameResource;
use App\Http\Resources\TopBoardgameByAssociationsResource;
use App\Http\Resources\TopBoardgameByUsersResource;
use App\Models\Association;
use App\Models\Boardgame;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GameStatsController extends Controller
{
    /**
     * Get the boardgame with the most games.
     */
    public function topBoardgame(){
        // Get the boardgame with the most games.
        $game = Boardgame::withCount('games')
            ->orderBy('games_count', 'desc')
            ->first();

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
    public function topBoardgamesByAssociations(){
        // Retrieving all games grouped by association and boardgame.
        $games = DB::table('games')
            ->select('association_id', 'boardgame_id', DB::raw('count(*) as games_count'))
            ->groupBy('association_id', 'boardgame_id')
            ->orderBy('association_id')
            ->get();

        // Grouping games by association and taking the top game for each association.
        $topsPerAssociation = $games
            ->groupBy('association_id')
            ->map(fn($rows) => $rows->sortByDesc('games_count')->first())
            ->values();

        // Retrieving associations and boardgames.
        $associationsIds = $topsPerAssociation->pluck('association_id')->unique();
        $boardgamesIds = $topsPerAssociation->pluck('boardgame_id')->unique();

        $associations = Association::whereIn('id', $associationsIds)->get()->keyBy('id');
        $boardgames = Boardgame::whereIn('id', $boardgamesIds)->get()->keyBy('id');

        // Creating DTO.
        $items = $topsPerAssociation->map(function($item) use ($associations, $boardgames){
            return (object) [
                'association' => $associations[$item->association_id],
                'boardgame' => $boardgames[$item->boardgame_id],
                'games_count' => $item->games_count,
            ];
        });

        // Returning spot.
        return TopBoardgameByAssociationsResource::collection($items); // resources only on models
    }

    /**
     * Get the boardgame with the most games by user.
     */
    public function topBoardgamesByUsers(){
        // Retrieving all games grouped by user and boardgame.
        $games = DB::table('games')
            ->join('game_user', 'games.id', '=', 'game_user.game_id')
            ->select('game_user.user_id', 'games.boardgame_id', DB::raw('count(*) as games_count'))
            ->groupBy('game_user.user_id', 'games.boardgame_id')
            ->orderBy('game_user.user_id')
            ->get();

        // Grouping games by user and taking the top game for each user.
        $topsPerUser = $games
            ->groupBy('user_id')
            ->map(fn($rows) => $rows->sortByDesc('games_count')->first())
            ->values();

        // Retrieving users and boardgames.
        $usersIds = $topsPerUser->pluck('user_id')->unique();
        $boardgamesIds = $topsPerUser->pluck('boardgame_id')->unique();

        $users = User::whereIn('id', $usersIds)->get()->keyBy('id');
        $boardgames = Boardgame::whereIn('id', $boardgamesIds)->get()->keyBy('id');

        // Creating DTO.
        $items = $topsPerUser->map(function($item) use ($users, $boardgames){
            return (object) [
                'user' => $users[$item->user_id],
                'boardgame' => $boardgames[$item->boardgame_id],
                'games_count' => $item->games_count,
            ];
        });

        // Returning spot.
        return TopBoardgameByUsersResource::collection($items); // resources only on models
    }
}
