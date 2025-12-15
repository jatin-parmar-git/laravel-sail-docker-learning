<?php

namespace App\Actions\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function execute(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)
                   ->where('type', 'user')  // Only allow regular users via API
                   ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create token (simple token without scopes - will use Spatie for permissions)
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user->type,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}