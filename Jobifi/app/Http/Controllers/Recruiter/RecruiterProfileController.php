<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecruiterProfileController extends Controller
{
    /**
     * Show the recruiter's public company profile page.
     */
    public function show(Request $request): View
    {
        $user = $request->user()
            ->load(['company.jobs', 'recruiterProfile']);

        $jobs      = $user->company?->jobs()->where('is_active', true)->latest()->get() ?? collect();
        $totalJobs = $jobs->count();

        return view('recruiter.profile.show', compact('user', 'jobs', 'totalJobs'));
    }
}
