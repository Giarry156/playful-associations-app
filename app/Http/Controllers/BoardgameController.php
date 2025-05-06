<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoardgameRequest;
use App\Http\Resources\BoardgameResource;
use App\Http\Resources\GenericResponseDataCollection;
use App\Models\Boardgame;
use Illuminate\Http\Request;

class BoardgameController extends Controller
{
    public function index() {
        $boardgames = Boardgame::all();

        return new GenericResponseDataCollection($boardgames);
    }

    public function show(Boardgame $boardgame) {
        return new BoardgameResource($boardgame);
    }

    public function store(CreateBoardgameRequest $request) {
        $validated = $request->validated();

        $boardgame = Boardgame::create($validated);
        return new BoardgameResource($boardgame);
    }
}
