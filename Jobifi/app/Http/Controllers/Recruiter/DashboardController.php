<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\InterviewSchedule;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

    $company = Auth::user()->company;

    if (!$company) {
        return view('recruiter.dashboard', [
            'activeJobs' => 0,
            'totalApplicants' => 0,
            'shortlisted' => 0,
            'interviews' => 0,
            'recentApplications' => collect(),
            'upcomingInterviews' => collect(),
            'company' => null,
        ]);
    }

    $companyId = $company->id;

        $activeJobs = Job::where('company_id', $companyId)
            ->where('is_active', true)
            ->count();

        $totalApplicants = Application::whereHas('job', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->count();

        $shortlisted = Application::whereHas('job', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            ->where('status', 'reviewed') // change if your status is "shortlisted"
            ->count();

        $interviews = InterviewSchedule::whereHas('application.job', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Applications
        |--------------------------------------------------------------------------
        */

        $recentApplications = Application::with([
            'user',
            'job'
        ])
            ->whereHas('job', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Upcoming Interviews
        |--------------------------------------------------------------------------
        */

        $upcomingInterviews = InterviewSchedule::with([
            'application.user',
            'application.job'
        ])
            ->whereHas('application.job', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->where('interview_at', '>=', now())
            ->orderBy('interview_at')
            ->take(5)
            ->get();

        return view('recruiter.dashboard', compact(
            'activeJobs',
            'totalApplicants',
            'shortlisted',
            'interviews',
            'recentApplications',
            'upcomingInterviews'
        ));
    }
}