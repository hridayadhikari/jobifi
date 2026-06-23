<?php

namespace App\Http\Controllers\Seeker;

use App\Models\Job;
use App\Models\Company;
use App\Models\Application;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with('job')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'seeker.applications.index',
            compact('applications')
        );
    }
    public function show(Application $application)
    {
        abort_if(
            $application->user_id !== Auth::id(),
            403
        );
$id= job::company();
        $application->load('job');
        $company = Company::with('user')->findOrFail($id);
        dd($company);

        $profile = Auth::user()->seekerProfile;
        return view('seeker.applications.show', compact('application', 'profile'));
    }
    public function create(Job $job)
    {
        $profile = Auth::user()->seekerProfile;

        return view('seeker.applications.create', compact('job', 'profile'));
    }

    public function store(Request $request, Job $job)
    {
        $request->validate([
            'resume'       => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|min:20',
        ]);

        $profile = Auth::user()->seekerProfile;

        // Default to whatever existing resume path was shown on the form.
        $resumePath = $request->input('existing_resume_path');

        // A newly uploaded file always takes priority over the existing one.
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store(
                'applications/resumes',
                'public'
            );
        }

        // Still nothing? Fall back to the profile directly, in case the
        // hidden field was tampered with or omitted.
        if (!$resumePath) {
            $resumePath = $profile?->resume_path;
        }

        if (!$resumePath) {
            return back()
                ->withInput()
                ->withErrors([
                    'resume' => 'Please upload a resume or add one to your profile.'
                ]);
        }

        Application::create([
            'job_id'       => $job->id,
            'user_id'      => Auth::id(),
            'resume_path'  => $resumePath,
            'cover_letter' => $request->cover_letter,
            'status'       => 'PENDING',
        ]);

        return redirect()
            ->route('seeker.applications.index')
            ->with('success', 'Application submitted successfully.');
    }
}
