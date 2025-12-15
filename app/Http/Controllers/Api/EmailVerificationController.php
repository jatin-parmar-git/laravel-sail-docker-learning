<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmailVerificationRequest;
use App\Actions\Api\SendEmailVerificationAction;
use App\Actions\Api\VerifyEmailAction;
use App\Actions\Api\CheckEmailVerificationStatusAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Send email verification notification
     */
    public function sendVerificationNotification(Request $request, SendEmailVerificationAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Verify email address
     */
    public function verify(EmailVerificationRequest $request, VerifyEmailAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Check verification status
     */
    public function status(Request $request, CheckEmailVerificationStatusAction $action): JsonResponse
    {
        return $action->execute($request);
    }
}