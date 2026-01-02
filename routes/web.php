<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Alumni\IntakeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->whereIn('provider', ['google', 'microsoft'])
    ->name('oauth.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->whereIn('provider', ['google', 'microsoft'])
    ->name('oauth.callback');


Route::get('/alumni/dashboard', function () {
    return view('alumni.dashboard');
})->middleware(['auth'])->name('alumni.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/alumni/intake', [IntakeController::class, 'edit'])->name('alumni.intake');
    Route::post('/alumni/intake', [IntakeController::class, 'update'])->name('alumni.intake.update');
});

require __DIR__.'/auth.php';
