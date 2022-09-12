<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        foreach ($user->roles as $role) {
            if ($role->name === "admin") {
                $users = User::query()
                    ->withCount('properties')
                    ->paginate(10);

                return response()->json([
                    'users' => $users
                ]);
            }
        }

        return response()->json([
            'message' => "You are not authorized",
        ], 401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = auth()->user();

        foreach ($user->roles as $role) {
            if ($role->name === "admin") {
                $user = new User([
                    'lastname' => $request['lastname'],
                    'firstname' => $request['firstname'],
                    'email' => $request['email'],
                    'password' => $request['password'],
                ]);

                $user->save();

                return response()->json([
                    'message' => "User created successfully!",
                    'property' => $user
                ], 201);
            }
        }

        return response()->json([
            'message' => "You are not authorized",
        ], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = auth()->user();

        foreach ($user->roles as $role) {
            if ($role->name === "admin") {
                $user = User::withCount('properties')->find($id);

                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                    ], 404);
                }

                return response()->json($user);
            }
        }

        return response()->json([
            'message' => "You are not authorized",
        ], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreUserRequest $request, int $id): JsonResponse
    {
        $connectedUser = auth()->user();

        foreach ($connectedUser->roles as $role) {
            if ($role->name === "admin") {
                $user = User::find($id);
                $user->update($request->all());

                return response()->json([
                    'message' => "User updated successfully!",
                    'property' => $user
                ]);
            }

            if ($role->name === "landlord") {
                $user = User::where('user_id', $connectedUser->id)
                    ->find($id)
                ;

                $user->update($request->all());

                return response()->json([
                    'message' => "User updated successfully!",
                    'property' => $user
                ]);
            }
        }

        return response()->json([
            'message' => "You are not authorized",
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $user = auth()->user();

        foreach ($user->roles as $role) {
            if ($role->name === "admin") {
                $user = User::find($id);

                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                    ], 404);
                }

                $user->properties()->delete();
                $user->delete();

                return response()->json([
                    'message' => "User deleted successfully!",
                    'property' => $user
                ]);
            }
        }

        return response()->json([
            'message' => "You are not authorized",
        ], 401);
    }
}
