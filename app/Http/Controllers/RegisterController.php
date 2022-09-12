<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'lastname' => ['required', 'max:100'],
            'firstname' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'max:100'],
        ]);

        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => "User created successfully!",
            'property' => $user
        ], 201);
    }
}
