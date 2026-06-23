<?php

use App\Http\Controllers\Recruiter\RecruiterProfileController;
use App\Http\Controllers\Recruiter\JobController;
use Illuminate\Support\Facades\Route;



//  Recruiter
Route::middleware(['auth', 'recruiter','userCheck'])->prefix('recruiter')->name('recruiter.')->group(function () {

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

