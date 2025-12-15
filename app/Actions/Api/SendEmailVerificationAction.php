<?php

namespace App\Actions\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendEmailVerificationAction
{
    public function execute(Request $request): JsonResponse
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
}