<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seeker\SeekerProfileController;
use App\Http\Controllers\Seeker\SeekerExperienceController;
use App\Http\Controllers\Seeker\SeekerEducationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
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
});


//  Recruiter 
Route::middleware(['auth', 'recruiter'])->group(function () {
    Route::get('/recruiter/dashboard', function () {
        return view('recruiter.dashboard');
    })->name('recruiter.dashboard');
});


//  Seeker
Route::middleware(['auth'])->prefix('seeker')->name('seeker.')->group(function () {

    Route::get('/dashboard', function () {
        return view('seeker.dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile',         [SeekerProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',    [SeekerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/basic', [SeekerProfileController::class, 'updateBasic'])->name('profile.basic.update');
    Route::post('/profile/cover',  [SeekerProfileController::class, 'updateCoverPhoto'])->name('profile.cover.update');
    Route::post('/profile/resume', [SeekerProfileController::class, 'updateResume'])->name('profile.resume.update');
    Route::patch('/profile/skills',[SeekerProfileController::class, 'updateSkills'])->name('profile.skills.update');

    // Experience
    Route::post('/experience',               [SeekerExperienceController::class, 'store'])->name('experience.store');
    Route::patch('/experience/{experience}', [SeekerExperienceController::class, 'update'])->name('experience.update');
    Route::delete('/experience/{experience}',[SeekerExperienceController::class, 'destroy'])->name('experience.destroy');

    // Education
    Route::post('/education',              [SeekerEducationController::class, 'store'])->name('education.store');
    Route::patch('/education/{education}', [SeekerEducationController::class, 'update'])->name('education.update');
    Route::delete('/education/{education}',[SeekerEducationController::class, 'destroy'])->name('education.destroy');
});


require __DIR__.'/auth.php';
