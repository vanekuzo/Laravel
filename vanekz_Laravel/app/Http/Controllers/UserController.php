<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ALL USERS
    public function index() {
        return response()->json(User::all(), 200);
    }

    // CREATE
    public function store(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($user, 201);
    }

    // SINGLE USER
    public function show($id) {
        return User::findOrFail($id);
    }

    // UPDATE
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    // DELETE
    public function destroy($id) {
        User::destroy($id);
        return response()->json(['message' => 'Deleted successfully'], 204);
    }
}