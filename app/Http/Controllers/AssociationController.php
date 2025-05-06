<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserBindToAssociationRequest;
use App\Http\Requests\UserUnbindToAssociationRequest;
use App\Http\Resources\AssociationResource;
use App\Http\Resources\GenericResponseDataCollection;
use App\Http\Resources\UserResource;
use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    public function index() {
        $associations = Association::all();
        return new GenericResponseDataCollection($associations);
    }

    public function bind(Association $association) {
        $user = auth()->user();
        $userBind = $user->associations()->where('association_id', $association->id)->first();

        if ($userBind) {
            return response()->json([
                'message' => 'User already bound to this association'
            ], 422);
        }

        $user->associations()->attach($association->id);

        return response()->json([
            'message' => 'User bound to association successfully',
            ...(new GenericResponseDataCollection([
                'association' => new AssociationResource($association),
                'user' => new UserResource($user)
            ])
            )
        ], 201);
    }

    public function unbind(Association $association) {
        $user = auth()->user();
        $userBind = $user->associations()->where('association_id', $association->id)->first();

        if (!$userBind) {
            return response()->json([
                'message' => 'User not bound to this association',
            ], 422);
        }

        $presidentId = $association->president_id;

        if ($user->id === $presidentId) {
            return response()->json([
                'message' => 'User is the president of this association and cannot be unbound',
            ], 422);
        }

        $user->associations()->detach($association->id);

        return response()->json([
            'message' => 'User unbound from association successfully',
            ...(new GenericResponseDataCollection([
                'association' => new AssociationResource($association),
                'user' => new UserResource($user)
            ])
            )
        ]);
    }
}
