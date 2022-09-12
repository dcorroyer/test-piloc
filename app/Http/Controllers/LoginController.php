<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Bad credentials']
            ]);
        }

        $login_credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($login_credentials)) {
            $userToken = auth()->user()->createToken('AuthToken')->accessToken;
            return response()->json(['token' => $userToken], 200);
        }
        else {
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json('Successfully disconnected', 200);
    }

    /**
     * This method returns authenticated user details
     */
    public function authenticatedUserDetails(){
        return response()->json([auth()->user()], 200);
    }
}
