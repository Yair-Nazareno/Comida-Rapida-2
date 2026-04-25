<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

// ── Auth público ──────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

// ── Auth protegido ────────────────────────────────────────────────
Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::post('logout',  [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me',       [AuthController::class, 'me']);
});

// ── Públicos — cualquiera puede ver ──────────────────────────────
Route::get('categories',             [CategoryController::class, 'index']);
Route::get('categories/{category}',  [CategoryController::class, 'show']);
Route::get('products',               [ProductController::class, 'index']);
Route::get('products/{product}',     [ProductController::class, 'show']);

// ── Protegidos — solo admin ───────────────────────────────────────
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('categories',              [CategoryController::class, 'store']);
    Route::put('categories/{category}',    [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    Route::post('products',               [ProductController::class, 'store']);
    Route::put('products/{product}',      [ProductController::class, 'update']);
    Route::delete('products/{product}',   [ProductController::class, 'destroy']);
});
