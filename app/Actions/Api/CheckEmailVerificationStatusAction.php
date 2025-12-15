<?php

namespace App\Actions\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckEmailVerificationStatusAction
{
    public function execute(Request $request): JsonResponse
    {
        return response()->json([
            'verified' => $request->user()->hasVerifiedEmail(),
            'email' => $request->user()->email,
            'verified_at' => $request->user()->email_verified_at,
        ]);
    }
}