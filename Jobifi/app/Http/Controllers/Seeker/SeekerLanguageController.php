<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\SeekerLanguage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeekerLanguageController extends Controller
{
    /** Store a new language entry. */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'language'    => ['required', 'string', 'max:100'],
            'proficiency' => ['required', 'in:native,fluent,professional,intermediate,basic'],
        ]);

        $profile = Auth::user()->seekerProfile()->firstOrCreate(['user_id' => Auth::id()]);

        $profile->languages()->create([
            'language'    => $request->language,
            'proficiency' => $request->proficiency,
        ]);

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Language added.');
    }

    /** Update an existing language entry. */
    public function update(Request $request, SeekerLanguage $language): RedirectResponse
    {
        // Ensure the language belongs to the authenticated user's profile
        abort_unless($language->seekerProfile->user_id === Auth::id(), 403);

        $request->validate([
            'language'    => ['required', 'string', 'max:100'],
            'proficiency' => ['required', 'in:native,fluent,professional,intermediate,basic'],
        ]);

        $language->update([
            'language'    => $request->language,
            'proficiency' => $request->proficiency,
        ]);

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Language updated.');
    }

    /** Delete a language entry. */
    public function destroy(SeekerLanguage $language): RedirectResponse
    {
        abort_unless($language->seekerProfile->user_id === Auth::id(), 403);

        $language->delete();

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Language removed.');
    }
}
