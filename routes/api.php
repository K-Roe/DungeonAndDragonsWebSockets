<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ========== PUBLIC / SHARED ==========

// sanctum / web user check
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'id'    => $request->user()->getId(),
        'name'  => $request->user()->getName(),
        'email' => $request->user()->getEmail(),
    ]);
});


// ========== WEB / SANCTUM ROUTES ==========
Route::middleware('auth:sanctum')->group(function () {

//    Route::prefix('savings')->group(function () {
//        Route::get('/', [SavingController::class, 'getSavings']);
//        Route::post('/remove', [SavingController::class, 'removeSavings']);
//        Route::delete('/{id}', [SavingController::class, 'deleteSavings']);
//    });
});
