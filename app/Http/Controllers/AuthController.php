<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
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

        return [
            'data' => [
                'token' => $token->plainTextToken
            ]
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ['message' => 'Token deleted'];
    }
}
