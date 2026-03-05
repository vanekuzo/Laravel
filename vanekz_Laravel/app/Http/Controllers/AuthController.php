<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'required|string|in:admin,writer'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->assignRole($data['role']);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(['user' => $user->load('roles', 'permissions'), 'token' => $token], 201);
    }

    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($data)) {
            return response(['message' => 'Invalid credentials'], 401);
        }
        $user = auth()->user();
        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        return response(['user' => $user->load('roles', 'permissions'), 'token' => $token ], 200);
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged out successfully']);
    }
}