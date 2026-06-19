<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

use App\Models\ActivityLog;


class AdminJobController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->search;

        $jobs = Job::with(['company', 'category'])

            ->when($search, function ($query) use ($search) {

                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })

            ->latest()
            ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }
    public function toggle(Job $job)
    {
       $title = $job->title;
       $job->update([
           
            'is_active' => !$job->is_active
        ]);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'JOB_STATUS UPDATED',
            'description' => 'Status Updated of  ' . $title,
        ]);

        return back()
            ->with('success', 'Job status updated successfully.');
    }
}
