<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;

Route::get('/login', function (Request $request) {
    return response()->json(['message' => 'Unauthorized'], 401);
});

// Register dan Login Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes dengan Sanctum Authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Resource Routes untuk Mahasiswa
    Route::apiResource('mahasiswa', MahasiswaController::class);
    
    // Resource Routes untuk Matakuliah
    Route::apiResource('matakuliah', MataKuliahController::class);
});
