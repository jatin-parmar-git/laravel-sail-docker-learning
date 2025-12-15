<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Actions\Api\LoginAction;
use App\Actions\Api\RegisterAction;
use App\Actions\Api\GetUserAction;
use App\Actions\Api\LogoutAction;
use App\Actions\Api\LogoutAllAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Register new user
     */
    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request, GetUserAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Logout user (revoke current token)
     */
    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Logout from all devices (revoke all tokens)
     */
    public function logoutAll(Request $request, LogoutAllAction $action): JsonResponse
    {
        return $action->execute($request);
    }
}