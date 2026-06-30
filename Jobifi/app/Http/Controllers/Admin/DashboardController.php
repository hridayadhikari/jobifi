<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Company;
use App\Models\Category;

class DashboardController extends Controller
{


    public function dashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'recruiters' => User::where('role', 'recruiter')->count(),
            'seekers' => User::where('role', 'seeker')->count(),
            'jobs' => Job::count(),
            'applications' => Application::count(),
            'companies' => Company::count(),
            'categories' => Category::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();

        $recentJobs = Job::with('company')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentJobs'
        ));
    }
}
