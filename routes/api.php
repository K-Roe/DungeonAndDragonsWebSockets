<?php


use App\Http\Controllers\Auth\MobileAuthController;
use Illuminate\Http\Request;


Route::middleware([])->prefix('mobile')->group(function () {
    Route::post('/login', [MobileAuthController::class, 'login']);
});
    // ✅ public mobile login (no auth)
#Route::post('/login', [MobileAuthController::class, 'login']);
Route::post('/register', [MobileAuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $r) => $r->user());
    Route::post('/logout', [MobileAuthController::class, 'logout']);
});
