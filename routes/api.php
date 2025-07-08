<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\Api\MutasiController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('checkApi')->group(function () {
    Route::apiResource('products', ProdukController::class);
    Route::get('products/{id}/mutasi', [ProdukController::class, 'mutasiHistory']);
    Route::apiResource('users', UserController::class);
     Route::get('users/{id}/mutasi', [UserController::class, 'mutasiHistory']);
    Route::apiResource('mutasis', MutasiController::class);
    Route::apiResource('lokasis', LokasiController::class);
});
