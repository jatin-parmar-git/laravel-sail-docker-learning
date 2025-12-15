<?php

namespace App\Actions\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutAction
{
    public function execute(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}