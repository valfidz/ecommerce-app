<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // registration
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        // create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['user' => $user], 201);
    }

    // login
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // check if credentials is valid or not
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'invalid login details'], 401);
        }

        // if credentials is valid, get data
        $user = $request->user();

        // create new token for this user
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    // logout
    public function logout(Request $request) {
        // Delete token
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged Out']);
    }
}
