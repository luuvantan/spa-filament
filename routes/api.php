<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');;

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/customers/index', [CustomerController::class, 'index']);
        Route::post('/customers/store', [CustomerController::class, 'store']);
    });
});
