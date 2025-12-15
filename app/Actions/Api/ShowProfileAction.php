<?php

namespace App\Actions\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowProfileAction
{
    public function execute(Request $request): JsonResponse
    {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'email_verified_at' => $request->user()->email_verified_at,
                'type' => $request->user()->type,
                'created_at' => $request->user()->created_at,
                'updated_at' => $request->user()->updated_at,
            ]
        ]);
    }
}