<?php

use App\Http\Controllers\Adventure\AdventureController;
use App\Http\Controllers\Auth\MobileAuthController;
use Illuminate\Http\Request;

Route::prefix('mobile')->group(function () {

    // Public mobile auth
    Route::post('/login', [MobileAuthController::class, 'login']);
    Route::post('/register', [MobileAuthController::class, 'register']);

    // Protected
    Route::middleware('mobile.auth')->group(function () {
        Route::prefix('adventures')->group(function () {
            Route::get('/active', [AdventureController::class, 'getActiveAdventures'])
                ->name('adventures.active');
            Route::post('/adventures/{id}/message', [AdventureController::class, 'sendMessage'])
                ->name('adventures.message');
        });

        Route::get('/me', fn (Request $r) => $r->user());
        Route::post('/logout', [MobileAuthController::class, 'logout']);
    });
});
