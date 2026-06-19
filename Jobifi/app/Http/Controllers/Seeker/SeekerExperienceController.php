<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seeker\StoreExperienceRequest;
use App\Models\SeekerExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SeekerExperienceController extends Controller
{
    public function store(StoreExperienceRequest $request): RedirectResponse
    {
        $profile = Auth::user()->seekerProfile()->firstOrCreate(['user_id' => Auth::id()]);

        $profile->experiences()->create([
            'job_title'    => $request->job_title,
            'company_name' => $request->company_name,
            'description'  => $request->description,
            'start_date'   => $request->start_date,
            'end_date'     => $request->is_current ? null : $request->end_date,
            'is_current'   => $request->boolean('is_current'),
        ]);

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Experience added.');
    }

    public function update(StoreExperienceRequest $request, SeekerExperience $experience): RedirectResponse
    {
        // Ownership check
        abort_if($experience->seekerProfile->user_id !== Auth::id(), 403);

        $experience->update([
            'job_title'    => $request->job_title,
            'company_name' => $request->company_name,
            'description'  => $request->description,
            'start_date'   => $request->start_date,
            'end_date'     => $request->boolean('is_current') ? null : $request->end_date,
            'is_current'   => $request->boolean('is_current'),
        ]);

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Experience updated.');
    }

    public function destroy(SeekerExperience $experience): RedirectResponse
    {
        abort_if($experience->seekerProfile->user_id !== Auth::id(), 403);

        $experience->delete();

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Experience removed.');
    }
}
