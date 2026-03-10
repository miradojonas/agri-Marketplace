<?php

use App\Http\Controllers\Api\FarmerController;
use App\Http\Controllers\Api\MarketPriceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Ussd\UssdController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────
// Health check
// ─────────────────────────────────────────
Route::get('/health', fn() => response()->json([
    'status'  => 'ok',
    'app'     => config('app.name'),
    'version' => '1.0.0',
]));

// ─────────────────────────────────────────
// Authentification
// ─────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'me']);
    });
});

// ─────────────────────────────────────────
// Routes publiques
// ─────────────────────────────────────────
Route::get('/products',           [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/categories',         [ProductController::class, 'categories']);
Route::get('/market-prices',      [MarketPriceController::class, 'index']);
Route::get('/farmers',            [FarmerController::class, 'index']);
Route::get('/farmers/{farmer}',   [FarmerController::class, 'show']);

// ─────────────────────────────────────────
// Routes protégées (connecté)
// ─────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Produits (agriculteurs)
    Route::post('/products',            [ProductController::class, 'store']);
    Route::put('/products/{product}',   [ProductController::class, 'update']);
    Route::delete('/products/{product}',[ProductController::class, 'destroy']);

    // Commandes
    Route::get('/orders',             [OrderController::class, 'index']);
    Route::post('/orders',            [OrderController::class, 'store']);
    Route::get('/orders/{order}',     [OrderController::class, 'show']);
    Route::put('/orders/{order}',     [OrderController::class, 'update']);
    Route::delete('/orders/{order}',  [OrderController::class, 'destroy']);

    // Profil agriculteur
    Route::get('/farmer/profile',    [FarmerController::class, 'profile']);
    Route::put('/farmer/profile',    [FarmerController::class, 'updateProfile']);
    Route::get('/farmer/orders',     [FarmerController::class, 'orders']);
    Route::get('/farmer/dashboard',  [FarmerController::class, 'dashboard']);

    // Prix du marché (admin)
    Route::post('/market-prices',           [MarketPriceController::class, 'store']);
    Route::put('/market-prices/{price}',    [MarketPriceController::class, 'update']);
    Route::delete('/market-prices/{price}', [MarketPriceController::class, 'destroy']);
});

// ─────────────────────────────────────────
// USSD (rate-limité par IP)
// ─────────────────────────────────────────
Route::middleware('throttle:ussd')->post('/ussd', [UssdController::class, 'handle']);