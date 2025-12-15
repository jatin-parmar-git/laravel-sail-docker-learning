<?php

namespace App\Actions\Api;

use App\Http\Requests\Api\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;

class UpdateProfileAction
{
    public function execute(ProfileUpdateRequest $request): JsonResponse
    {
        $user = $request->user();
        $emailChanged = $user->email !== $request->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $emailChanged ? null : $user->email_verified_at, // Reset verification if email changed
        ]);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'type' => $user->type,
                'updated_at' => $user->updated_at,
            ],
            'email_verification_required' => $emailChanged,
        ]);
    }
}