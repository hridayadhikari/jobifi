<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seeker\StoreEducationRequest;
use App\Models\SeekerEducation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SeekerEducationController extends Controller
{
    public function store(StoreEducationRequest $request): RedirectResponse
    {
        $profile = Auth::user()->seekerProfile()->firstOrCreate(['user_id' => Auth::id()]);

        $profile->educations()->create($request->validated());

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Education added.');
    }

    public function update(StoreEducationRequest $request, SeekerEducation $education): RedirectResponse
    {
        abort_if($education->seekerProfile->user_id !== Auth::id(), 403);

        $education->update($request->validated());

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Education updated.');
    }

    public function destroy(SeekerEducation $education): RedirectResponse
    {
        abort_if($education->seekerProfile->user_id !== Auth::id(), 403);

        $education->delete();

        return redirect()->route('seeker.profile.edit')
                         ->with('success', 'Education removed.');
    }
}
