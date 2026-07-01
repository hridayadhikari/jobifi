<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    /**
     * Display recruiter listing.
     */
    public function index(Request $request)
    {
        $recruiters = User::query()
            ->where('role', 'recruiter')
            ->with(['company'])
            ->when($request->search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('company', function ($company) use ($search) {

                            $company->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.recruiter.index', compact('recruiters'));
    }

    /**
     * Suspend recruiter.
     */
    public function suspend(User $user)
    {
        if ($user->role !== 'recruiter') {
            abort(404);
        }

        $user->update([
            'is_active' => false,
        ]);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'RECRUITER SUSPENDED',
            'description' => 'Recruiter Name :' . $user->name,
        ]);
        return back()->with(
            'success',
            'Recruiter suspended successfully.'
        );
    }

    /**
     * Activate recruiter.
     */
    public function activate(User $user)
    {
        if ($user->role !== 'recruiter') {
            abort(404);
        }

        $user->update([
            'is_active' => true,
        ]);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'RECRUITER ACTIVATED',
            'description' => 'Recruiter Name :' . $user->name,
        ]);
        return back()->with(
            'success',
            'Recruiter activated successfully.'
        );
    }

    /**
     * View recruiter company.
     */
    public function company($id)
    {
       $id =   $id = decryptId($id);

    $user = User::findOrFail($id);
        if ($user->role !== 'recruiter') {
            abort(404);
        }

        $user->load('company.jobs');

        $jobs = $user->company ? $user->company->jobs->sortByDesc('created_at') : collect();
        $totalJobs = $jobs->count();

        return view(
            'admin.recruiter.company',
            compact('user', 'jobs', 'totalJobs')
        );
    }
   public function profile($id)
{
     $id = decryptId($id);

    $user = User::findOrFail($id);
    // Ensure the user is a recruiter
    if ($user->role !== 'recruiter') {
        abort(404);
    }

    // Eager load the company and its jobs, sorting jobs by newest first at the database level
    $user->load(['company', 'company.jobs' => function ($query) {
        $query->latest(); 
    }]);

    // Safely retrieve jobs and the total count
    $jobs = $user->company ? $user->company->jobs : collect();
    $totalJobs = $jobs->count();

    // Return the show view with all necessary variables
    return view(
        'admin.recruiter.show', // Fixed typo from 'profie' to 'show'
        compact('user', 'jobs', 'totalJobs')
    );
}
}
