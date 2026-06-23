<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    public function index()
    {
        $savedJobs = auth()->user()
            ->savedJobs()
            ->with(['company', 'category'])
            ->latest()
            ->paginate(10);

        return view('seeker.SavedJob.index', compact('savedJobs'));
    }

    public function toggle(Job $job)
    {
        $user = auth()->user();

        if ($user->savedJobs()->where('job_id', $job->id)->exists()) {

            $user->savedJobs()->detach($job->id);

            return back()->with(
                'success',
                'Job removed from saved jobs.'
            );
        }

        $user->savedJobs()->attach($job->id);

        return back()->with(
            'success',
            'Job saved successfully.'
        );
    }
}