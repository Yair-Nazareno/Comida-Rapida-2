<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TableController;

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

// ── Mesas — autenticados pueden ver ──────────────────────────────
Route::middleware('auth:api')->group(function () {
    Route::get('tables',       [TableController::class, 'index']);
    Route::get('tables/{table}', [TableController::class, 'show']);

    // Cajero y trabajador pueden cambiar estado
    Route::middleware('role:admin,cajero,trabajador')
         ->patch('tables/{table}/status', [TableController::class, 'updateStatus']);
});

// ── Protegidos — solo admin ───────────────────────────────────────
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('categories',              [CategoryController::class, 'store']);
    Route::put('categories/{category}',    [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    Route::post('products',               [ProductController::class, 'store']);
    Route::put('products/{product}',      [ProductController::class, 'update']);
    Route::delete('products/{product}',   [ProductController::class, 'destroy']);

       // Mesas — solo admin crea, edita y elimina
    Route::post('tables',            [TableController::class, 'store']);
    Route::put('tables/{table}',     [TableController::class, 'update']);
    Route::delete('tables/{table}',  [TableController::class, 'destroy']);
});
