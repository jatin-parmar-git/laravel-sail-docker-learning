<?php

namespace App\Actions\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DeleteAccountAction
{
    public function execute(Request $request): RedirectResponse
    {
        $request->validateWithBag('adminDeletion', [
            'password' => ['required', 'current_password:admin'],
        ]);

        $admin = $request->user();

        Auth::guard('admin')->logout();

        $admin->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/admin/login');
    }
}