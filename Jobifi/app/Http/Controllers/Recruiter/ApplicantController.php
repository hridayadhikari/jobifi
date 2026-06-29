<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Job;
use App\Models\SeekerProfile;
use App\Models\InterviewSchedule;
use App\Models\ProfileView;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Application::with([
            'user',
            'job',

        ])
            ->whereHas('job', function ($q) {
                $q->where('company_id', auth::user()->company->id);
            });

        // Search by applicant name
        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // Filter by job
        if ($request->filled('job')) {
            $query->where('job_id', $request->job);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query
            ->latest()
            ->paginate(10);

        $jobs = Job::where('company_id', auth::user()->company->id)->get();

        return view(
            'recruiter.applicants.index',
            compact('applications', 'jobs')
        );
    }

    public function show(Application $application)
    {



        $application->load([
            'user',
            'job',
            'user.seekerProfile'
        ]);

        if (Auth::user()->role === 'recruiter') {

            ProfileView::create([
                'seeker_id'    => $application->user->id,
                'recruiter_id' => Auth::id(),
            ]);
        }

        abort_if(
            $application->job->company_id !== auth::user()->company->id,
            403
        );

        return view(
            'recruiter.applicants.show',
            compact('application')
        );
    }

    public function updateStatus(Request $request, Application $application)
    {
        abort_if(
            $application->job->company_id !== auth::user()->company->id,
            403
        );

        $request->validate([
            'status' => 'required'
        ]);

        $application->update([
            'status' => $request->status
        ]);

        return back()->with(
            'success',
            'Application status updated successfully.'
        );
    }
    public function scheduleInterview(Request $request, Application $application)
    {


        $request->validate([
            'interview_at' => 'required|date',
            'meeting_link' => 'required|url',
            'notes' => 'nullable|string',
        ]);

        InterviewSchedule::updateOrCreate(
            [
                'application_id' => $application->id,
            ],
            [
                'interview_at' => $request->interview_at,
                'meeting_link' => $request->meeting_link,
                'notes' => $request->notes,
            ]
        );

        $application->update([
            'status' => 'interview_scheduled',
        ]);

        return back()->with('success', 'Interview scheduled successfully.');
    }


    public function applicantsByJob(Request $request, Job $job)
    {
        abort_if(
            $job->company_id !== Auth::user()->company->id,
            403
        );

        $query = Application::with([
            'user',
            'job'
        ])->where('job_id', $job->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query
            ->latest()
            ->paginate(10);

        return view(
            'recruiter.jobs.applicants',
            compact('job', 'applications')
        );
    }
}
