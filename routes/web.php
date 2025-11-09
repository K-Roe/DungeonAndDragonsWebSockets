<?php

use App\Events\TestMessage;
use App\Http\Controllers\Adventure\AdventureController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'getUser'])->name('user.getUser');

    // Game routes
    Route::post('/adventures', [AdventureController::class, 'store'])->name('adventures.store');
    Route::get('/adventures/active', [AdventureController::class, 'getActiveAdventures'])
        ->name('adventures.active');
    Route::post('/adventures/{id}/message', [AdventureController::class, 'sendMessage'])
        ->name('adventures.message');

});

// 🔊 Broadcasting routes — must come before the Vue catch-all
Broadcast::routes(['middleware' => ['web', 'auth']]);
require base_path('routes/channels.php');

Route::get('/broadcast', function () {
    broadcast(new TestMessage('🔥 Shot you with a fire Ball!'));
    return 'Event has been sent!';
});

// Vue catch-all (keep this last)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
