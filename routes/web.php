<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::middleware('auth')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])
        ->name('notifications.fetch');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

    Route::delete('/notifications', [NotificationController::class, 'clearAll'])
        ->name('notifications.clearAll');
});

Route::get('/helper-test', function () {
    return encryptId(123);
});


Route::get('/', function () {
    return view('welcome');
});



// Shared profile route (role-aware redirect)
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





require __DIR__ . '/admin.php';
require __DIR__ . '/seeker.php';
require __DIR__ . '/recruiter.php';
require __DIR__ . '/auth.php';

