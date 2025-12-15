<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordController extends Controller
{
    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if user exists and is of type 'user'
        $user = User::where('email', $request->email)
                   ->where('type', 'user')
                   ->first();

        if (!$user) {
            return response()->json([
                'message' => 'We can\'t find a user with that email address.',
            ], 404);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Password reset link sent to your email.',
                'status' => $status,
            ]);
        }

        return response()->json([
            'message' => 'Unable to send reset link. Please try again.',
            'status' => $status,
        ], 500);
    }

    /**
     * Reset password using token
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

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