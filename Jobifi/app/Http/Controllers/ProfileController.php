<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class ProfileController extends Controller
{
    /**
     * Redirect to the role-specific profile page.
     */
    public function edit(Request $request): mixed
    {
        $role = $request->user()->role;

        return match ($role) {
            'seeker'    => redirect()->route('seeker.profile.edit'),
            'recruiter' => view('recruiter.profile.edit', ['user' => $request->user()]),
            'admin'     => view('admin.profile.edit',     ['user' => $request->user()]),
            default     => view('profile.edit',           ['user' => $request->user()]),
        };
    }

    /**
     * Update name + email (shared — used by admin & recruiter views).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')
                ->store('profile_photos', 'public');
            $request->user()->profile_photo = $path;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
