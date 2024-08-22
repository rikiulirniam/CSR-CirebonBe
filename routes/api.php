<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\MitraAuthController;
use App\Http\Controllers\KegiatanController;
use App\Http\Middleware\MitraCheck;
use App\Http\Middleware\RoleChecker;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Mockery\Undefined;

Route::get('/auth', [AuthController::class, 'check'])->middleware('auth:sanctum');




// Admin Routes
Route::prefix('/admin')->group(function () {
    // Auth
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);

        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:admin');
        Route::get('/', [AuthController::class, 'index'])->middleware('auth:admin');
    });
    Route::middleware('auth:admin')->group(function () {
        Route::apiResource('/kegiatan', KegiatanController::class);
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



});
