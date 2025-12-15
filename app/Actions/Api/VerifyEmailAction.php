<?php

namespace App\Actions\Api;

use App\Http\Requests\Api\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailAction
{
    public function execute(EmailVerificationRequest $request): JsonResponse
    {
        // Find user
        $user = User::find($request->id);

        if (!$user) {
            return response()->json([
                'message' => 'Invalid verification link.',
            ], 400);
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email address is already verified.',
            ]);
        }

        // Check hash
        if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Invalid verification link.',
            ], 400);
        }

        // Check if link is expired
        if ($request->expires < now()->timestamp) {
            return response()->json([
                'message' => 'Verification link has expired.',
            ], 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'message' => 'Email address verified successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
            ],
        ]);
    }
}