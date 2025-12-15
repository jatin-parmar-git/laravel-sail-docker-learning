<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\EmailVerificationController;

// Public routes (no authentication required)
Route::get('/ping', fn() => ['status' => 'ok', 'timestamp' => now()]);

// Auth routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Password reset routes
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])
        ->name('password.email');
    Route::post('/reset-password', [PasswordController::class, 'reset'])
        ->name('password.store');
});

// Email verification route (can be accessed without auth for verification links)
Route::post('/verify-email', [EmailVerificationController::class, 'verify'])
    ->name('verification.verify');

// Protected routes (require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth-related protected routes
    Route::prefix('auth')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    });
    
    // Profile management routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'updatePassword']);
        Route::delete('/', [ProfileController::class, 'destroy']);
    });
    
    // Email verification routes (protected)
    Route::prefix('email')->group(function () {
        Route::get('/verification-status', [EmailVerificationController::class, 'status']);
        Route::post('/verification-notification', [EmailVerificationController::class, 'sendVerificationNotification'])
            ->middleware('throttle:6,1');
    });
    
    // Posts routes - example protected resources
    Route::get('/posts', function () {
        return ['posts' => [
            ['id' => 1, 'title' => 'First Post', 'content' => 'This is the first post'],
            ['id' => 2, 'title' => 'Second Post', 'content' => 'This is the second post'],
            ['id' => 3, 'title' => 'Third Post', 'content' => 'This is the third post'],
        ]];
    });
    
    Route::post('/posts', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        return response()->json([
            'message' => 'Post created successfully',
            'post' => [
                'id' => rand(1000, 9999),
                'title' => $request->title,
                'content' => $request->content,
                'created_at' => now(),
            ],
        ], 201);
    });
});