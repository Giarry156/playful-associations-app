<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAssociationGameRequest;
use App\Http\Resources\GenericResponseDataCollection;
use App\Models\Association;
use App\Models\Game;
use Illuminate\Http\Request;

class AssociationGameController extends Controller
{
    public function index(){
        $associationGames = Game::all();
        return new GenericResponseDataCollection($associationGames);
    }

    public function store(Association $association, CreateAssociationGameRequest $request) {
        $user = $request->user();
        $userPresidencyAssociations = $user->presidencyAssociations()->pluck('id')->toArray();

        if (!in_array($association->id, $userPresidencyAssociations)) {
            return response()->json(['message' => 'You are not authorized to create games for this association.'], 403);
        }

        $validated = $request->validated();

        $game = Game::create([
            'association_id' => $association->id,
            'boardgame_id' => $validated['boardgame_id'],
        ]);

        $game->users()->attach($validated['users']);


    }
}
