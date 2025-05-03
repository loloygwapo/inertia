<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
Route::post('/post-job', [JobController::class, 'store'])->middleware('auth')->name('jobs.store');
Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])
->middleware(['auth', 'can:apply,job'])
->name('jobs.apply');


Route::get('/post-job', function () {
    return Inertia::render('PostJob');
})->name('post-job');


Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
