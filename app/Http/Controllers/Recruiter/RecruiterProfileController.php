<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RecruiterProfileController extends Controller
{
    // ─────────────────────────────────────────────────────────
    //  RECRUITER COMPANY PROFILE — SHOW (read-only, owner view)
    // ─────────────────────────────────────────────────────────

    /**
     * Show the recruiter's company profile page.
     * Redirects to create if no company exists yet.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $user = $request->user()->load('company.jobs');

        if (! $user->company) {
            return redirect()->route('recruiter.profile.company.create')
                ->with('info', 'Create your company profile to get started.');
        }

        $jobs      = $user->company->jobs()->where('is_active', true)->latest()->get();
        $totalJobs = $jobs->count();

        return view('recruiter.profile.show', compact('user', 'jobs', 'totalJobs'));
    }

    // ─────────────────────────────────────────────────────────
    //  COMPANY — CREATE
    // ─────────────────────────────────────────────────────────

    /**
     * Show the blank company creation form.
     */
    public function companyCreate(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        // Already has a company → redirect to edit
        if ($user->company) {
            return redirect()->route('recruiter.profile.company.edit')
                ->with('info', 'You already have a company profile. Edit it here.');
        }

        return view('recruiter.profile.company-create', compact('user'));
    }

    /**
     * Store a newly created company.
     */
    public function companyStore(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Guard: one recruiter → one company
        if ($user->company) {
            return redirect()->route('recruiter.profile.show');
        }

        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:150'],
            'description'           => ['nullable', 'string', 'max:5000'],
            'website'               => ['nullable', 'url', 'max:255'],
            'logo'                  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover_photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'headquarters_location' => ['nullable', 'string', 'max:150'],
            'industry'              => ['nullable', 'string', 'max:100'],
            'founded_year'          => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'employee_count'        => ['nullable', 'string', 'max:50'],
            'designation'           => ['nullable', 'string', 'max:100'],
            'phone'                 => ['nullable', 'string', 'max:30'],
            'linkedin_url'          => ['nullable', 'url', 'max:255'],
        ]);

        $logoPath = $request->hasFile('logo')
            ? $request->file('logo')->store('logos', 'public')
            : null;

        $coverPhotoPath = $request->hasFile('cover_photo')
            ? $request->file('cover_photo')->store('cover_photos', 'public')
            : null;

        $user->company()->create([
            'name'                  => $validated['name'],
            'description'           => $validated['description'] ?? null,
            'website'               => $validated['website'] ?? null,
            'logo_path'             => $logoPath,
            'cover_photo'           => $coverPhotoPath,
            'headquarters_location' => $validated['headquarters_location'] ?? null,
            'industry'              => $validated['industry'] ?? null,
            'founded_year'          => $validated['founded_year'] ?? null,
            'employee_count'        => $validated['employee_count'] ?? null,
        ]);

        // Save recruiter-specific fields directly on the user row
        $user->update([
            'designation'  => $validated['designation'] ?? null,
            'phone'        => $validated['phone'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
        ]);

        return redirect()->route('recruiter.profile.show')
            ->with('status', 'company-created');
    }

    // ─────────────────────────────────────────────────────────
    //  COMPANY — EDIT / UPDATE
    // ─────────────────────────────────────────────────────────

    /**
     * Show the company edit form pre-filled with existing data.
     */
    public function companyEdit(Request $request): View|RedirectResponse
    {
        $user = $request->user()->load('company');

        if (! $user->company) {
            return redirect()->route('recruiter.profile.company.create');
        }

        return view('recruiter.profile.company-edit', compact('user'));
    }

    /**
     * Persist company updates.
     */
    public function companyUpdate(Request $request): RedirectResponse
    {
        $user    = $request->user()->load('company');
        $company = $user->company;

        if (! $company) {
            return redirect()->route('recruiter.profile.company.create');
        }

        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:150'],
            'description'           => ['nullable', 'string', 'max:5000'],
            'website'               => ['nullable', 'url', 'max:255'],
            'logo'                  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover_photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'headquarters_location' => ['nullable', 'string', 'max:150'],
            'industry'              => ['nullable', 'string', 'max:100'],
            'founded_year'          => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'employee_count'        => ['nullable', 'string', 'max:50'],
            'designation'           => ['nullable', 'string', 'max:100'],
            'phone'                 => ['nullable', 'string', 'max:30'],
            'linkedin_url'          => ['nullable', 'url', 'max:255'],
        ]);

        // Swap logo if a new one was uploaded
        $logoPath = $company->logo_path;
        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $coverPhotoPath = $company->cover_photo;
        if ($request->hasFile('cover_photo')) {
            if ($company->cover_photo) {
                Storage::disk('public')->delete($company->cover_photo);
            }
            $coverPhotoPath = $request->file('cover_photo')->store('cover_photos', 'public');
        }

        $company->update([
            'name'                  => $validated['name'],
            'description'           => $validated['description'] ?? null,
            'website'               => $validated['website'] ?? null,
            'logo_path'             => $logoPath,
            'cover_photo'           => $coverPhotoPath,
            'headquarters_location' => $validated['headquarters_location'] ?? null,
            'industry'              => $validated['industry'] ?? null,
            'founded_year'          => $validated['founded_year'] ?? null,
            'employee_count'        => $validated['employee_count'] ?? null,
        ]);

        // Update recruiter fields directly on the user row
        $user->update([
            'designation'  => $validated['designation'] ?? null,
            'phone'        => $validated['phone'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
        ]);

        return redirect()->route('recruiter.profile.show')
            ->with('status', 'company-updated');
    }
}
