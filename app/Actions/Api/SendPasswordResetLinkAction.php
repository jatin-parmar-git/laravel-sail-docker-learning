<?php

namespace App\Actions\Api;

use App\Http\Requests\Api\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class SendPasswordResetLinkAction
{
    public function execute(PasswordResetRequest $request): JsonResponse
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
}