<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\MitraAuthController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\MitraProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\SektorController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\MitraCheck;
use App\Http\Middleware\RoleChecker;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Mockery\Undefined;



Route::get('/auth', [AuthController::class, 'check'])->middleware(AuthCheck::class);
Route::prefix('/public')->group(function () {

    Route::get('/kecamatan', function () {
        return response()->json(['kecamatan' => Kecamatan::all()]);
    });

    Route::get('/sektor', [SektorController::class, 'index']);
    Route::get('/sektor/{id}', [SektorController::class, 'show']);

    Route::get('/mitra', [MitraController::class, 'index']);
    Route::get('/mitra/{id}', [MitraController::class, 'show']);

    Route::get('/kegiatan', [KegiatanController::class, 'index']);
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);

    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/{id}', [LaporanController::class, 'show']);

    Route::get('/proyek', [ProyekController::class, 'index']);
    Route::get('/proyek/{id}', [ProyekController::class, 'show']);

    Route::get('/program', [ProgramController::class, 'index']);
    Route::get('/program/{id}', [ProgramController::class, 'show']);
});
// Admin Routes
Route::prefix('/admin')->group(function () {
    // Auth
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);

        Route::post('/logout', [AuthController::class, 'logout'])->middleware(AdminCheck::class);
    });

    Route::middleware(AdminCheck::class)->group(function () {
        Route::apiResource('/profile', ProfileController::class);
        Route::apiResource('/kegiatan', KegiatanController::class);
        Route::apiResource('/sektor', SektorController::class);
        Route::apiResource('/mitra', MitraController::class);
        Route::apiResource('/proyek', ProyekController::class);
        Route::apiResource('/laporan', LaporanController::class);
        Route::apiResource('/users', UserController::class)->except('show');
        Route::get('/users/Admin/{id}', [UserController::class, 'userAdmin']);
        Route::get('/users/Mitra/{id}', [UserController::class, 'userMitra']);
        Route::put('/users/Admin/{id}', [UserController::class, 'udpateAdmin']);
        Route::put('/users/Mitra/{id}', [UserController::class, 'updateMitra']);
    });
});


// Mitra Routes
Route::prefix('/mitra')->group(function () {
    // Auth 
    Route::prefix('/auth')->group(function () {
        Route::post('/register', [MitraAuthController::class, 'register']);
        Route::post('/login', [MitraAuthController::class, 'login']);
    });
    // Route::get('/', [MitraAuthController::class, 'index'])->middleware(MitraCheck::class);
    Route::middleware(MitraCheck::class)->group(function () {
        Route::apiResource('/profile', MitraProfileController::class);
        Route::apiResource('/laporan', LaporanController::class);
        Route::post('/logout', [MitraAuthController::class, 'logout']);
    });
});
