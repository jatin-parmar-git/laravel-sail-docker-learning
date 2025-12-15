<?php

namespace App\Actions\Admin;

use App\Http\Requests\Admin\AdminPasswordResetLinkRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkAction
{
    public function execute(AdminPasswordResetLinkRequest $request): RedirectResponse
    {
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}