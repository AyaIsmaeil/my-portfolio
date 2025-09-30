<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials',
            ],401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ],200);
    }
    function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }
}
