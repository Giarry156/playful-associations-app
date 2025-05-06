<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGameRequest;
use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Models\Association;
use App\Models\Boardgame;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Get all games.
     */
    public function index()
    {
        // Returning spot.
        return new GameCollection(Game::all());
    }

    /**
     * Get a game.
     */
    public function show(Game $game)
    {
        // Returning spot.
        return new GameResource($game);
    }

    /**
     * Create a game.
     */
    public function store(CreateGameRequest $request)
    {
        // Retrieving the authenticated user.
        $user = $request->user();

        // Retrieving validated payload.
        $validated = $request->validated();

        // Retrieving association.
        $association = Association::find($validated['association_id']);

        // Checking if the user is the president of the association.
        if($association->president_id !== $user->id) {
            return response()->json(['error' => 'You are not authorized to create a game for this association.'], 401);
        }

        // Retrieving boardgame.
        $boardgame = Boardgame::find($validated['boardgame_id']);

        // Checking if the number of users is less than or equal to the number of players.
        if(count($validated['users']) > $boardgame->number_of_players) {
            return response()->json(['error' => 'The number of users exceeds the maximum number of players for this boardgame.'], 422);
        }

        // Checking if all the users are members of the association.
        foreach ($validated['users'] as $userId) {
            $user = $association->users()->find($userId);
            if (!$user) {
                return response()->json(['error' => 'All users must be members of the association.'], 422);
            }
        }

        // Creating game.
        $game = Game::create([
            'boardgame_id' => $validated['boardgame_id'],
            'association_id' => $validated['association_id'],
        ]);
        $game->users()->attach($validated['users']);

        // Returning spot.
        return new GameResource($game);
    }
}
