<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' =>$user,
            'access_token' => $accessToken
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'message' => 'This User does not exist, check your details',
            ], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'user' => auth()->user(),
            'access_token' => $accessToken
        ], 200);
    }
}
