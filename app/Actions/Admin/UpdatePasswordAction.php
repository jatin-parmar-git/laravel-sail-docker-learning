<?php

namespace App\Actions\Admin;

use App\Http\Requests\Admin\AdminPasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UpdatePasswordAction
{
    public function execute(AdminPasswordUpdateRequest $request): RedirectResponse
    {
        $admin = $request->user();
        
        $admin->update([
            'password' => Hash::make($request->validated()['password']),
        ]);

        return Redirect::route('admin.profile.edit')->with('status', 'password-updated');
    }
}