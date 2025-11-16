<?php

use App\Http\Controllers\Auth\MobileAuthController;
use Illuminate\Http\Request;

Route::prefix('mobile')->group(function () {

    // Public mobile auth
    Route::post('/login', [MobileAuthController::class, 'login']);
    Route::post('/register', [MobileAuthController::class, 'register']);

    // Protected
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', fn (Request $r) => $r->user());
        Route::post('/logout', [MobileAuthController::class, 'logout']);
    });
});
