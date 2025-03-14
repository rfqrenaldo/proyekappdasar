<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Google OAuth
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

// Rute dashboard (hanya untuk pengguna yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SocialiteController::class, 'index'])->name('dashboard');
    Route::post('/logout', [SocialiteController::class, 'logout'])->name('logout');
});
