<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login with email + password and issue access token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    ['message' => 'The provided credentials are incorrect.']
                ]
            ], 401);
        }

        $token = $user->createToken($user->id);

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
    }

    /**
     * Logout user and destroy the token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Token destroyed successfully']);
    }
}
