<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\Skill;
use App\Models\ActivityLog;
use Illuminate\Http\Request;


class JobController extends Controller
{
    /**
     * Display a paginated list of jobs posted by the authenticated recruiter's company.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve the company associated with the authenticated user
        $company = auth()->user()->company;

        // Redirect to company profile creation if no company exists
        if (!$company) {
            return redirect()
                ->route('recruiter.profile.company.create')
                ->with('error', 'Please create a company profile first.');
        }

        // Fetch jobs ordered by most recent, paginated for performance
        $jobs = $company->jobs()->orderBy('created_at', 'desc')->paginate(5);

        return view('recruiter.jobs.index', compact('jobs'));
    }

    /**
     * Show the form to create a new job posting.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Load active categories and all skills for the form
        $categories = Category::where('is_active', true)->get();

        $skills = Skill::orderBy('name')->get();

        return view('recruiter.createjob', compact(
            'categories',
            'skills'
        ));
    }

    /**
     * Store a newly created job posting in the database.
     * Associates the job with the recruiter's company and syncs required skills.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate job details and required skill IDs
        $validated = $this->validateJobRequest($request, true);

        // Retrieve the recruiter's company
        $company = auth()->user()->company;

        // Verify company exists before creating job
        if (!$company) {
            return back()->with(
                'error',
                'Please create a company profile before posting jobs.'
            );
        }

        // Create job and associate it with the company
        $job = $company->jobs()->create([
            'category_id'  => $validated['category_id'],
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'type'         => $validated['type'],
            'location'     => $validated['location'],
            'salary_range' => $validated['salary_range'] ?? null,
            'is_active'    => true,
        ]);

        // Attach required skills to the job using the job_skill pivot table
        $job->skills()->sync($validated['skill_ids']);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'JOB_CREATED',
            'description' => 'Created job: ' . $job->title,
        ]);

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job posted successfully.');
    }


    public function edit(Job $job)
    {
        // Authorize that the job belongs to the recruiter's company
        $this->authorizeJob($job);

        // Load categories and skills for the edit form dropdown/selection
        $categories = Category::where('is_active', true)->get();
        $skills = Skill::orderBy('name')->get();

        return view('recruiter.jobs.edit', compact(
            'job',
            'categories',
            'skills'
        ));
    }


    public function update(Request $request, Job $job)
    {
        // Verify job ownership before allowing update
        $this->authorizeJob($job);

        // Validate job fields; skills are optional on update
        $validated = $this->validateJobRequest($request, false);

        // Update job attributes
        $job->update([
            'category_id'  => $validated['category_id'],
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'type'         => $validated['type'],
            'location'     => $validated['location'],
            'salary_range' => $validated['salary_range'] ?? null,
        ]);

        // Sync skills: use submitted skills or keep existing if not provided
        $job->skills()->sync($validated['skill_ids'] ?? $job->skills->pluck('id')->toArray());
          ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'JOB_UPDATED',
            'description' => 'Updated job: ' . $job->title,
        ]);

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job updated successfully.');
    }


    public function destroy(Job $job)
    {
        // Verify job ownership before allowing deletion
        $this->authorizeJob($job);

        // Soft delete the job (preserves associated data integrity)
        $job->delete();
          ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'JOB_DELETED',
            'description' => 'Deleted job: ' . $job->title,
        ]);

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    /**
     * Validate job request data.
     * 
     * Skill IDs can be required (for store) or optional (for update).
     * All other job fields are always required.
     * 
     * @param \Illuminate\Http\Request $request
     * @param bool $requireSkills Whether skill_ids must be present
     * @return array Validated data
     */
    protected function validateJobRequest(Request $request, bool $requireSkills = true): array
    {
        // Base validation rules for all job fields
        $rules = [
            'title'        => ['required', 'string', 'max:255'],
            'category_id'  => ['required', 'exists:categories,id'],
            'type'         => ['required', 'in:full-time,part-time,contract,internship'],
            'location'     => ['required', 'string', 'max:255'],
            'salary_range' => ['nullable', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'skill_ids.*'  => ['exists:skills,id'],
        ];

        // Make skill_ids required on store, optional on update
        $rules['skill_ids'] = $requireSkills
            ? ['required', 'array']
            : ['nullable', 'array'];

        return $request->validate($rules);
    }

    /**
     * Authorize that the job belongs to the authenticated recruiter's company.
     * 
     * Aborts with 403 Forbidden if unauthorized.
     * 
     * @param \App\Models\Job $job
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeJob(Job $job): void
    {
        // Retrieve the authenticated recruiter's company
        $company = auth()->user()->company;

        // Verify company exists and job belongs to it
        if (!$company || $job->company_id !== $company->id) {
            abort(403);
        }
    }
}
