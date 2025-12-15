<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminProfileUpdateRequest;
use App\Http\Requests\Admin\AdminPasswordUpdateRequest;
use App\Actions\Admin\UpdateProfileAction;
use App\Actions\Admin\UpdatePasswordAction;
use App\Actions\Admin\DeleteAccountAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the admin's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'admin' => $request->user(),
        ]);
    }

    /**
     * Update the admin's profile information.
     */
    public function update(AdminProfileUpdateRequest $request, UpdateProfileAction $action): RedirectResponse
    {
        return $action->execute($request);
    }

    /**
     * Show the form for changing password.
     */
    public function editPassword(Request $request): View
    {
        return view('admin.profile.change-password', [
            'admin' => $request->user(),
        ]);
    }

    /**
     * Update the admin's password.
     */
    public function updatePassword(AdminPasswordUpdateRequest $request, UpdatePasswordAction $action): RedirectResponse
    {
        return $action->execute($request);
    }

    /**
     * Delete the admin's account.
     */
    public function destroy(Request $request, DeleteAccountAction $action): RedirectResponse
    {
        return $action->execute($request);
    }
}