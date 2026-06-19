<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seeker\SeekerProfileController;
use App\Http\Controllers\Seeker\SeekerExperienceController;
use App\Http\Controllers\Seeker\SeekerEducationController;
use App\Http\Controllers\Recruiter\RecruiterProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Recruiter\JobController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.register');
});


// Shared profile route (role-aware redirect)
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//  Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('skills', SkillController::class)->names([
        'index' => 'skills.index',
        'store' => 'skills.store',
        'destroy' => 'skills.destroy',
    ]);

    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('categories.store');
    Route::get(
        '/categories/{category}/edit',
        [CategoryController::class, 'edit']
    )->name('categories.edit');

    Route::patch('/categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    Route::patch(
        '/categories/{category}/toggle-status',
        [CategoryController::class, 'toggleStatus']
    )
        ->name('categories.toggle-status');
    Route::get('/admin/logs', [ActivityLogController::class, 'index'])
        ->name('admin.logs.index');

    Route::get('/admin/jobs', [AdminJobController::class, 'index'])
        ->name('admin.jobs.index');

    Route::patch('/admin/jobs/{job}/toggle', [AdminJobController::class, 'toggle'])
        ->name('admin.jobs.toggle');
});


//  Recruiter
Route::middleware(['auth', 'recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {

    Route::get('/dashboard', function () {
        return view('recruiter.dashboard');
    })->name('dashboard');

    // ── Recruiter / Company Profile ──────────────────────────
    Route::get('/profile',                [RecruiterProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/company/create', [RecruiterProfileController::class, 'companyCreate'])->name('profile.company.create');
    Route::post('/profile/company',       [RecruiterProfileController::class, 'companyStore'])->name('profile.company.store');
    Route::get('/profile/company/edit',   [RecruiterProfileController::class, 'companyEdit'])->name('profile.company.edit');
    Route::patch('/profile/company',      [RecruiterProfileController::class, 'companyUpdate'])->name('profile.company.update');

    //Create Job
    Route::get('/jobs', [JobController::class, 'index'])
        ->name('jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])
        ->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])
        ->name('jobs.store');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
        ->name('jobs.edit');
    Route::patch('/jobs/{job}', [JobController::class, 'update'])
        ->name('jobs.update');
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
        ->name('jobs.destroy');
});


//  Seeker
Route::middleware(['auth'])->prefix('seeker')->name('seeker.')->group(function () {

    Route::get('/dashboard', function () {
        return view('seeker.dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile',          [SeekerProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit/',     [SeekerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/basic',  [SeekerProfileController::class, 'updateBasic'])->name('profile.basic.update');
    Route::post('/profile/cover',   [SeekerProfileController::class, 'updateCoverPhoto'])->name('profile.cover.update');
    Route::post('/profile/resume',  [SeekerProfileController::class, 'updateResume'])->name('profile.resume.update');
    Route::patch('/profile/skills', [SeekerProfileController::class, 'updateSkills'])->name('profile.skills.update');
    // Experience
    Route::post('/experience',               [SeekerExperienceController::class, 'store'])->name('experience.store');
    Route::patch('/experience/{experience}', [SeekerExperienceController::class, 'update'])->name('experience.update');
    Route::delete('/experience/{experience}', [SeekerExperienceController::class, 'destroy'])->name('experience.destroy');

    // Education
    Route::post('/education',              [SeekerEducationController::class, 'store'])->name('education.store');
    Route::patch('/education/{education}', [SeekerEducationController::class, 'update'])->name('education.update');
    Route::delete('/education/{education}', [SeekerEducationController::class, 'destroy'])->name('education.destroy');
});


require __DIR__ . '/auth.php';
