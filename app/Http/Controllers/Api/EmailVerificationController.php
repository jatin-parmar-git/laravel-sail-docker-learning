<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use App\Models\User;

class EmailVerificationController extends Controller
{
    /**
     * Send email verification notification
     */
    public function sendVerificationNotification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email address is already verified.',
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification link sent to your email address.',
        ]);
    }

    /**
     * Verify email address
     */
    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'hash' => 'required|string',
            'expires' => 'required|integer',
            'signature' => 'required|string',
        ]);

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

        // Verify the URL signature
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

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

    /**
     * Check verification status
     */
    public function status(Request $request)
    {
        return response()->json([
            'verified' => $request->user()->hasVerifiedEmail(),
            'email' => $request->user()->email,
            'verified_at' => $request->user()->email_verified_at,
        ]);
    }
}