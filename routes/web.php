<?php

use App\Events\TestMessage;
//use App\Http\Controllers\AuthController;
use App\Http\Controllers\Adventure\AdventureController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'register']);
//Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);


Route::middleware('auth')->group(function () {

    Route::get('/user', function (Request $request) {
        return response()->json([
            'id'    => $request->user()->getId(),
            'name'  => $request->user()->getName(),
            'email' => $request->user()->getEmail(),
        ]);
    });
    //game routes
    Route::post('/adventures', [AdventureController::class, 'store'])->name('adventures.store');
//    Route::get('/adventures/active', [AdventureController::class, 'active']);
//    Route::post('/adventures/{id}/message', [AdventureController::class, 'sendMessage']);
    Route::get('/adventures/active', [AdventureController::class, 'getActiveAdventures'])
        ->name('adventures.active');
});

Route::get('/broadcast', function () {
    broadcast(new TestMessage('🔥 Shot you with a fire Ball!'));
    return 'Event has been sent!';
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
