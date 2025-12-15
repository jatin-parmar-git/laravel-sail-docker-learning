<?php

namespace App\Actions\Api;

use App\Http\Requests\Api\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction
{
    public function execute(ResetPasswordRequest $request): JsonResponse
    {
        // Check if user exists and is of type 'user'
        $user = User::where('email', $request->email)
                   ->where('type', 'user')
                   ->first();

        if (!$user) {
            return response()->json([
                'message' => 'We can\'t find a user with that email address.',
            ], 404);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Optionally revoke all existing tokens after password reset
                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Password has been reset successfully.',
                'status' => $status,
            ]);
        }

        return response()->json([
            'message' => 'Unable to reset password. Please check your token and try again.',
            'status' => $status,
            'errors' => [
                'email' => [trans($status)],
            ],
        ], 422);
    }
}