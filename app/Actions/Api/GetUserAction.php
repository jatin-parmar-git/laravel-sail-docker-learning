<?php

namespace App\Actions\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserAction
{
    public function execute(Request $request): JsonResponse
    {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'type' => $request->user()->type,
            ],
            'tokens' => $request->user()->tokens()->count(),
        ]);
    }
}