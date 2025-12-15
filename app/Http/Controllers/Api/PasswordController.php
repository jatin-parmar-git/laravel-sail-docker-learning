<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PasswordResetRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Actions\Api\SendPasswordResetLinkAction;
use App\Actions\Api\ResetPasswordAction;
use Illuminate\Http\JsonResponse;

class PasswordController extends Controller
{
    /**
     * Send password reset link
     */
    public function sendResetLink(PasswordResetRequest $request, SendPasswordResetLinkAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Reset password using token
     */
    public function reset(ResetPasswordRequest $request, ResetPasswordAction $action): JsonResponse
    {
        return $action->execute($request);
    }
}