<?php

use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────
// Pages publiques
// ─────────────────────────────────────────
Route::get('/',             fn() => view('home'))->name('home');
Route::get('/produits',     fn() => view('products.index'))->name('products.index');
Route::get('/produits/{id}', fn() => view('products.show'))->name('products.show');
Route::get('/prix-marche',  fn() => view('market-prices'))->name('market-prices');
Route::get('/a-propos',     fn() => view('about'))->name('about');

// ─────────────────────────────────────────
// Auth
// ─────────────────────────────────────────
Route::get('/connexion',    fn() => view('auth.login'))->name('login');
Route::get('/inscription',  fn() => view('auth.register'))->name('register');

// ─────────────────────────────────────────
// Dashboard (protégé)
// ─────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});
