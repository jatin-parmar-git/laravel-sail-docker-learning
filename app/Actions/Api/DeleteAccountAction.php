<?php

namespace App\Actions\Api;

use App\Http\Requests\Api\DeleteAccountRequest;
use Illuminate\Http\JsonResponse;

class DeleteAccountAction
{
    public function execute(DeleteAccountRequest $request): JsonResponse
    {
        $user = $request->user();
        
        // Revoke all tokens
        $user->tokens()->delete();
        
        // Delete user
        $user->delete();

        return response()->json([
            'message' => 'Account deleted successfully',
        ]);
    }
}