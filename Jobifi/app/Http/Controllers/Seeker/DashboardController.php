<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\InterviewSchedule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hour = now()->hour;

        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 17) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }

        $appliedJobsCount = Application::where('user_id', $user->id)->count();
        $savedJobsCount = $user->savedJobs()->count();
        $interviewsCount = Application::where('user_id', $user->id)->where('status', 'SHORTLISTED')->count();

        $recentApplications = Application::with(['job.company'])
            ->where('user_id', $user->id)
            ->latest() // <--- Change to this
            ->take(3)
            ->get();

        $profileViews = Auth::user()->profileViews()->count();
        $upcomingInterviews = InterviewSchedule::with([
            'application.job.company'
        ])
            ->whereHas('application', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('interview_at', '>=', now())
            ->orderBy('interview_at')
            ->get();


       

        return view('seeker.dashboard', compact(
            'greeting',
            'appliedJobsCount',
            'savedJobsCount',
            'interviewsCount',
            'recentApplications',
            'profileViews',
            'upcomingInterviews',

        ));
    }
}
