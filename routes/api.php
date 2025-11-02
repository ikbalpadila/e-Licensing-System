<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\{
    PermitApplicationController,
    DocumentController,
    PaymentController,
    VerificationController,
    ApprovalController

};

// Default
Route::get('/', fn() => response()->json(['message' => 'e-Licensing API Running 🚀']));

// Auth routes (optional: Sanctum)
// Route::middleware('auth:sanctum')->group(function () {

Route::prefix('permits')->group(function () {
    Route::get('/', [PermitApplicationController::class, 'index'])->middleware('role:officer,admin');
    Route::post('/', [PermitApplicationController::class, 'store'])->middleware('role:citizen');
    Route::get('/{id}', [PermitApplicationController::class, 'show']);
    Route::put('/{id}', [PermitApplicationController::class, 'update'])->middleware('role:citizen,admin');
    Route::delete('/{id}', [PermitApplicationController::class, 'destroy'])->middleware('role:admin');

    // Nested routes
    Route::prefix('{applicationId}')->group(function () {
        Route::apiResource('documents', DocumentController::class)->only(['index', 'store', 'destroy']);
        Route::post('payment', [PaymentController::class, 'store'])->middleware('role:citizen');
        Route::get('payment', [PaymentController::class, 'show']);
        Route::post('verification', [VerificationController::class, 'store'])->middleware('role:officer');
        Route::post('approval', [ApprovalController::class, 'store'])->middleware('role:supervisor');
    });
});

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (require Sanctum auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Citizen access
    Route::middleware('role:citizen')->group(function () {
        Route::post('/permits', [PermitApplicationController::class, 'store']);
        Route::get('/permits/my', [PermitApplicationController::class, 'index']);
    });

    // Officer access
    Route::middleware('role:officer')->group(function () {
        Route::get('/permits', [PermitApplicationController::class, 'index']);
        Route::put('/permits/{id}', [PermitApplicationController::class, 'update']);
    });

    // Admin access
    Route::middleware('role:admin')->group(function () {
        Route::delete('/permits/{id}', [PermitApplicationController::class, 'destroy']);
    });
});

// });
