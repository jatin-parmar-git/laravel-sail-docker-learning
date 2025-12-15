<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminPasswordResetLinkRequest;
use App\Actions\Admin\PasswordResetLinkAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(AdminPasswordResetLinkRequest $request, PasswordResetLinkAction $action): RedirectResponse
    {
        return $action->execute($request);
    }
}