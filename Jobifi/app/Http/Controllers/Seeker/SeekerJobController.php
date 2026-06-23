<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;

class SeekerJobController extends Controller
{

    public function index(Request $request)
    {
        $jobs = Job::with([
            'company',
            'category',
            'skills'
        ])
            ->where('is_active', 1);

        if ($request->filled('search')) {

            $jobs->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('location')) {

            $jobs->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('category')) {
            $jobs->whereIn('category_id', $request->category);
        }

        if ($request->filled('type')) {
            $jobs->whereIn('type', $request->type);
        }

        
        if ($request->input('sort') === 'oldest') {
            $jobs->oldest();
        } else {
            $jobs->latest();
        }

        $jobs = $jobs
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $categories = Category::all();

        $savedJobIds = auth()->user()
            ->savedJobs
            ->pluck('id')
            ->toArray();


        return view(
            'seeker.jobs.index',
            compact('jobs', 'categories', 'savedJobIds')
        );
    }
    public function show(Job $job)
    {
        $job->load([
            'company',
            'category',
            'skills'
        ]);
        $isSaved = auth()->user()
            ->savedJobs()
            ->where('job_id', $job->id)
            ->exists();

        return view('seeker.jobs.show', compact('job', 'isSaved'));
    }
}
