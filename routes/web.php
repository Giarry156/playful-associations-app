<?php

use App\Models\Association;
use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    if (auth()->check()) {
        return redirect()->route('welcome');
    }

    return view('register');
})->name('register');

Route::get('/login', function () {
    if (\Illuminate\Support\Facades\Auth::user()) {
        return redirect()->route('welcome');
    }

    return view('login');
})->name('login');

Route::get('/login_form', [\App\Http\Controllers\UserController::class, 'loginForm'])->name('login_form');

Route::get('/user_settings', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        $user = auth()->user();

        return view('user_settings', [
            'user' => $user,
        ]);
    }

    return view('login');
})->name('settings');

Route::post('/user_settings_update', [\App\Http\Controllers\UserController::class, 'updateUser'])->name('update_user_settings');

Route::post('/logout', function () {
    if (auth()->check()) {
        auth()->user()->tokens()->delete();
        auth()->logout();
    }

    return redirect()->route('login');
})->name('logout');

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    $presidencyAssociations = Association::where('president_id', $user->id)->get();
    $bindAssociations = $user->associations()->get();
    $games = $user->games()->get();

    return view('welcome', [
        'presidencyAssociations' => $presidencyAssociations,
        'bindAssociations' => $bindAssociations,
        'games' => $games,
        'user' => $user,
    ]);
});
