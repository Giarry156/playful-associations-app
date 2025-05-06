<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(CreateUserRequest $request) {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return new UserResource($user);
    }

    /**
     * Login a user.
     */
    public function login(LoginUserRequest $request) {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !password_verify($validated['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
