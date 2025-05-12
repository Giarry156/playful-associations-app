<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserBindToAssociationRequest;
use App\Http\Requests\UserUnbindToAssociationRequest;
use App\Http\Resources\AssociationCollection;
use App\Http\Resources\AssociationResource;
use App\Http\Resources\GenericResponseDataCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    /**
     * Get all associations.
     * @return AssociationCollection
     */
    public function index(): AssociationCollection
    {
        $associations = Association::all();
        return new AssociationCollection($associations);
    }

    /**
     * Bind user to an association.
     */
    public function bind(Association $association)
    {
        $user = auth()->user();
        $userBind = $user->associations()->where('associations.id', $association->id)->exists();

        if (!$userBind) {
            $user->associations()->attach($association->id);
        }

        return response()->json([
            'message' => 'User bound to association successfully',
            'data' => [
                'association' => new AssociationResource($association),
                'user' => new UserResource($user)
            ]
        ], 201);
    }

    /**
     * Unbind user from an association.
     */
    public function unbind(Association $association)
    {
        $user = auth()->user();
        $userBind = $user->associations()->where('associations.id', $association->id)->exists();

        if ($userBind) {
            $presidentId = $association->president_id;

            if ($user->id === $presidentId) {
                return response()->json([
                    'message' => 'User is the president of this association and cannot be unbound',
                ], 422);
            }

            $user->associations()->detach($association->id);
        }

        return response()->json([
            'message' => 'User unbound from association successfully',
            'data' => [
                'association' => new AssociationResource($association),
                'user' => new UserResource($user)
            ]
        ]);
    }

    public function getUsers(Association $association)
    {
        $user = auth()->user();
        $presidentId = $association->president_id;

        if ($user->id !== $presidentId) {
            return response()->json([
                'message' => 'Only authorized users can access this resource',
            ], 422);
        }

        $users = $association->users()->get();
        return new UserCollection($users);
    }
}
