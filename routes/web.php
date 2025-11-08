<?php

use App\Events\TestMessage;
//use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'register']);
//Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);



Route::get('/broadcast', function () {
    broadcast(new TestMessage('🔥 Hello from Laravel!'));
    return 'Event has been sent!';
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
