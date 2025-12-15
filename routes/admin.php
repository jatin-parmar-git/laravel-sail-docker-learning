<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {
    // Admin login routes (accessible when not authenticated)
    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('login')->middleware('guest:admin');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.store')->middleware('guest:admin');
    
    // Protected admin routes (require admin authentication)
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});