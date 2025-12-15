<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;

Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {
    // Admin root route - redirect to dashboard if authenticated, login if not
    Route::get('/', function () {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    })->name('index');
    
    // Admin login routes (accessible when not authenticated)
    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('login')->middleware('guest:admin');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.store')->middleware('guest:admin');
    
    // Admin password reset routes (accessible when not authenticated)
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request')->middleware('guest:admin');
    
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email')->middleware('guest:admin');
    
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset')->middleware('guest:admin');
    
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store')->middleware('guest:admin');
    
    // Protected admin routes (require admin authentication)
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        // Admin profile management routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});