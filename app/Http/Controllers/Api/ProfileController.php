<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileUpdateRequest;
use App\Http\Requests\Api\UpdatePasswordRequest;
use App\Http\Requests\Api\DeleteAccountRequest;
use App\Actions\Api\ShowProfileAction;
use App\Actions\Api\UpdateProfileAction;
use App\Actions\Api\UpdatePasswordAction;
use App\Actions\Api\DeleteAccountAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get user profile
     */
    public function show(Request $request, ShowProfileAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Update user profile
     */
    public function update(ProfileUpdateRequest $request, UpdateProfileAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Update password
     */
    public function updatePassword(UpdatePasswordRequest $request, UpdatePasswordAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Delete account
     */
    public function destroy(DeleteAccountRequest $request, DeleteAccountAction $action): JsonResponse
    {
        return $action->execute($request);
    }
}