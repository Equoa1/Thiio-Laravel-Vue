<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
    Route::put('/update-account', [AuthController::class, 'updateAccount'])->middleware('auth:api');

    Route::get('/users', [AuthController::class, 'index'])->middleware('auth:api');
    Route::get('/users/{id}', [AuthController::class, 'show'])->middleware('auth:api');
    Route::post('/users', [AuthController::class, 'store'])->middleware('auth:api');
    Route::put('/users/{id}', [AuthController::class, 'update'])->middleware('auth:api');
    Route::delete('/users/{id}', [AuthController::class, 'destroy'])->middleware('auth:api');
});


