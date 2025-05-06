<?php

use App\Http\Controllers\AssociationController;
use App\Http\Controllers\BoardgameController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameStatsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureHttpMethodSupported;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/users')->name('users.')->group(function () {
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::prefix('/boardgames')->name('boardgames.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [BoardgameController::class, 'index'])->name('index');
    Route::post('/', [BoardgameController::class, 'store'])->name('store');
    Route::get('/{boardgame}', [BoardgameController::class, 'show'])->name('show');
});

Route::prefix('/associations')->name('associations.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AssociationController::class, 'index'])->name('index');
    Route::post('/{association}/bind', [AssociationController::class, 'bind'])->name('bind');
    Route::post('/{association}/unbind', [AssociationController::class, 'unbind'])->name('unbind');
});

Route::prefix('/games')->name('games.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('index');
    Route::post('/', [GameController::class, 'store'])->name('store');
    Route::get('/{game}', [GameController::class, 'show'])->name('show');

    Route::prefix('/stats')->name('stats.')->group(function () {
        Route::prefix('/top')->name('top.')->group(function () {
            Route::prefix('/boardgames')->name('boardgames.')->group(function () {
                Route::get('/', [GameStatsController::class, 'topBoardgame'])->name('topBoardgame');
                Route::get('/associations', [GameStatsController::class, 'topBoardgamesByAssociations'])->name('topBoardgamesByAssociations');
                Route::get('/users', [GameStatsController::class, 'topBoardgamesByUsers'])->name('topBoardgamesByUsers');
            });
        });
    });
});
