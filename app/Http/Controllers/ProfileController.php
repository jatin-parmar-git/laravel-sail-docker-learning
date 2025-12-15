<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\ProfileUpdateRequest;
use App\Actions\Web\UpdateProfileAction;
use App\Actions\Web\DeleteAccountAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, UpdateProfileAction $action): RedirectResponse
    {
        return $action->execute($request);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, DeleteAccountAction $action): RedirectResponse
    {
        return $action->execute($request);
    }
}
