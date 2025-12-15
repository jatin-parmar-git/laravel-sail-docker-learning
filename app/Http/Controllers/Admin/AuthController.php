<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Actions\Admin\LoginAction;
use App\Actions\Admin\LogoutAction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function login(AdminLoginRequest $request, LoginAction $action): RedirectResponse
    {
        return $action->execute($request);
    }

    public function logout(Request $request, LogoutAction $action): RedirectResponse
    {
        return $action->execute($request);
    }
}