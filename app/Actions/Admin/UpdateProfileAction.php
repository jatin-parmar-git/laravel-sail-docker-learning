<?php

namespace App\Actions\Admin;

use App\Http\Requests\Admin\AdminProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UpdateProfileAction
{
    public function execute(AdminProfileUpdateRequest $request): RedirectResponse
    {
        $admin = $request->user();
        $admin->fill($request->validated());

        if ($admin->isDirty('email')) {
            $admin->email_verified_at = null;
        }

        $admin->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }
}