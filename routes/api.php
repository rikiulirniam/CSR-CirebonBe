<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\MitraAuthController;
use App\Http\Middleware\MitraCheck;
use App\Http\Middleware\RoleChecker;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::post('/admin_login', [AuthController::class, 'login']);

// Admin Routes
Route::prefix('/admin')->group(function () {
    // Auth
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);

        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:admin');
        Route::get('/', [AuthController::class, 'index'])->middleware('auth:admin');
    });
});


// Mitra Routes
Route::prefix('/mitra')->group(function () {
    // Auth 
    Route::prefix('/auth')->group(function () {
        Route::post('/register', [MitraAuthController::class, 'register']);
        Route::post('/login', [MitraAuthController::class, 'login']);

        Route::get('/', [MitraAuthController::class, 'index'])->middleware(MitraCheck::class);
        Route::post('/logout', [MitraAuthController::class, 'logout'])->middleware(MitraCheck::class);
    });


    // 

});
