<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $credentials = $request->only(['username', 'password']);
        if (!auth()->attempt($credentials)) {
            return response(['message' => 'Authenticate error'], 422);
        }

        /** @var User */
        $user = auth()->user();
        if (!$user->access_token) {
            $token = $user->createToken('app_token');
            if (!$user->update(['access_token' => $token->plainTextToken])) {
                return response(['message' => 'Create access token error'], 422);
            }
        }
        return response($user);
    }
}
