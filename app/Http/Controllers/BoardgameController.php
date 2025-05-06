<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoardgameRequest;
use App\Http\Resources\BoardgameCollection;
use App\Http\Resources\BoardgameResource;
use App\Http\Resources\GenericResponseDataCollection;
use App\Models\Boardgame;
use Illuminate\Http\Request;

class BoardgameController extends Controller
{
    /**
     * Get all boardgames.
     */
    public function index() {
        return new BoardgameCollection(Boardgame::all());
    }

    /**
     * Get a single boardgame.
     */
    public function show(Boardgame $boardgame) {
        return new BoardgameResource($boardgame);
    }

    /**
     * Create a new boardgame.
     */
    public function store(CreateBoardgameRequest $request) {
        $validated = $request->validated();

        $boardgame = Boardgame::create($validated);
        return new BoardgameResource($boardgame);
    }
}
