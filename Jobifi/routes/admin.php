<?php


use App\Http\Controllers\SkillController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\RecruiterController;
use App\Http\Controllers\Admin\SeekerController;
use App\Http\Controllers\Admin\UserTableController;
use Illuminate\Support\Facades\Route;




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

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit',[CategoryController::class, 'edit'] )->name('categories.edit');
    Route::patch('/categories/{category}', [CategoryController::class, 'update']) ->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']) ->name('categories.destroy');
    Route::patch( '/categories/{category}/toggle-status',[CategoryController::class, 'toggleStatus'] )->name('categories.toggle-status');
    Route::get('/admin/logs', [ActivityLogController::class, 'index']) ->name('admin.logs.index');

    Route::get('/admin/jobs', [AdminJobController::class, 'index'])->name('admin.jobs.index');

    Route::patch('/admin/jobs/{job}/toggle', [AdminJobController::class, 'toggle'])->name('admin.jobs.toggle');


    Route::get('/recruiters',[RecruiterController::class, 'index'])->name('admin.recruiters.index');
 

    Route::post('/recruiters/{user}/suspend',[RecruiterController::class, 'suspend'])->name('admin.recruiters.suspend');

    Route::post('/recruiters/{user}/activate',[RecruiterController::class, 'activate'] )->name('admin.recruiters.activate');

    Route::get('/recruiters/{user}/company', [RecruiterController::class, 'company'])->name('admin.recruiters.company');
  // Core User Management
    Route::get('/users', [UserTableController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/suspend', [UserTableController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/activate', [UserTableController::class, 'activate'])->name('users.activate');

    // Role-Specific Profile Routes
    Route::get('/recruiters/{user}/profile', [RecruiterController::class, 'profile'])->name('recruiters.show');
    Route::get('/seekers/{user}/profile', [SeekerController::class, 'show'])->name('seeker.show');
});
