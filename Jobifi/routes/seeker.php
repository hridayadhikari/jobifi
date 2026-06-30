<?php


use App\Http\Controllers\Seeker\SeekerProfileController;
use App\Http\Controllers\Seeker\SeekerExperienceController;
use App\Http\Controllers\Seeker\SeekerEducationController;
use App\Http\Controllers\Seeker\SeekerJobController;
use App\Http\Controllers\Seeker\SavedJobController;
use App\Http\Controllers\Seeker\ApplicationController;
use App\Http\Controllers\Seeker\DashboardController;
use Illuminate\Support\Facades\Route;


//  Seeker
Route::middleware(['auth','userCheck'])->prefix('seeker')->name('seeker.')->group(function () {

    Route::get('/seeker/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/jobs', [SeekerJobController::class, 'index'])
        ->name('jobs.index');
    Route::get('/jobs/{job}', [SeekerJobController::class, 'show'])
        ->name('jobs.show');
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

    //Saved Job
    Route::get('/savedjobs', [SavedJobController::class, 'index'])->name('saved-jobs.index');
    Route::post('/jobs/{job}/save', [SavedJobController::class, 'toggle'])->name('jobs.save');

    //Appy Jobs
    Route::get('/applications/{application}',[ApplicationController::class, 'show'])->name('applications.show');
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/jobs/{job}/apply',[ApplicationController::class, 'create'])->name('jobs.apply.form');
    Route::post('/jobs/{job}/apply',[ApplicationController::class, 'store'])->name('jobs.apply');
    Route::delete('/applications/{application}',[ApplicationController::class, 'destroy'])->name('applications.destroy');
});
