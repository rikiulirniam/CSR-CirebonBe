<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(["message" => "Not Found"]);
});

use App\Http\Controllers\Auth\VerificationController;

Route::get('/verify-email/{token}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/verify_redirect', [VerificationController::class, 'redirect'])->name('verification.redirect');
