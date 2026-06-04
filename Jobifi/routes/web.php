<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {


    Route::get('/admin/dashboard', function () {
        return  view('admin.dashboard');
    })->name('admin.dashboard');

  

});
Route::middleware(['auth', 'recruiter'])->group(function () {


    Route::get('/recruiter/dashboard', function () {
        return  view('recruiter.dashboard');
    })->name('recruiter.dashboard');

  

});
Route::middleware(['auth'])->group(function () {

    Route::get('/seeker/dashboard', function () {
        return view('seeker.dashboard');
    })->name('seeker.dashboard');

});

require __DIR__.'/auth.php';
