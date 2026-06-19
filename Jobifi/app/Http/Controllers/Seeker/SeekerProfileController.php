<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seeker\UpdateBasicInfoRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SeekerProfileController extends Controller
{
    /**
     * Show the read-only public profile page.
     */
    public function show(): View
    {
        $user    = Auth::user();
        $profile = $user->seekerProfile()->firstOrCreate(['user_id' => $user->id]);
        $profile->load(['experiences', 'educations', 'skills', 'languages']);

        return view('seeker.profile.show', compact('user', 'profile'));
    }

    /**
     * Show the seeker-specific profile edit page.
     */
    public function edit(): View
    {

        $user    = Auth::user();
        $profile = $user->seekerProfile()->firstOrCreate(['user_id' => $user->id]);

        $profile->load(['experiences', 'educations', 'skills', 'languages']);
        $allSkills = Skill::orderBy('name')->get();


        return view('seeker.profile.edit', compact('user', 'profile', 'allSkills'));
    }


    /**
     * Update general info: name, headline, bio, phone, address, socials.
     */
    public function updateBasic(UpdateBasicInfoRequest $request): RedirectResponse
    {
        $user    = Auth::user();
        $profile = $user->seekerProfile()->firstOrCreate(['user_id' => $user->id]);

        // Update users table (name only — email stays in Breeze settings)
        $user->name = trim($request->first_name . ' ' . $request->last_name);
        $user->save();

        // Update seeker_profiles table
        $profile->update([
            'headline'      => $request->headline,
            'bio'           => $request->bio,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'portfolio_url' => $request->portfolio_url,
            'linkedin_url'  => $request->linkedin_url,
            'github_url'    => $request->github_url,
        ]);

        return redirect()->route('seeker.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Upload cover photo.
     */
    public function updateCoverPhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'cover_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $user    = Auth::user();
        $profile = $user->seekerProfile()->firstOrCreate(['user_id' => $user->id]);

        $path = $request->file('cover_photo')->store('cover_photos', 'public');
        $profile->update(['cover_photo' => $path]);

        return redirect()->route('seeker.profile.edit')
            ->with('success', 'Cover photo updated.');
    }

    /**
     * Upload resume (PDF/DOC/DOCX).
     */
    public function updateResume(Request $request): RedirectResponse
    {
        $request->validate([
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $user    = Auth::user();
        $profile = $user->seekerProfile()->firstOrCreate(['user_id' => $user->id]);

        $originalName = $request->file('resume')->getClientOriginalName();
        $path         = $request->file('resume')->store('resumes', 'public');

        $profile->update([
            'resume_path'          => $path,
            'resume_original_name' => $originalName,
        ]);

        return redirect()->route('seeker.profile.edit')
            ->with('success', 'Resume uploaded successfully.');
    }

    /**
     * Sync skills (array of skill IDs).
     */
    public function updateSkills(Request $request)
    {
        $validated = $request->validate([
            'skill_ids'   => 'nullable|array',
            'skill_ids.*' => 'exists:skills,id',
        ]);

        $profile = auth()->user()->seekerProfile;

        $profile->skills()->sync(
            $validated['skill_ids'] ?? []
        );

        return back()->with('success', 'Skills updated.');
    }
}
