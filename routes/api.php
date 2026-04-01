<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProduitController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/produits', [ProduitController::class, 'index']);
    Route::get('/produits/{produit}', [ProduitController::class, 'show']);
    Route::get('/commandes', [CommandeController::class, 'index']);
    Route::post('/commandes', [CommandeController::class, 'store']);
    Route::get('/commandes/{commande}', [CommandeController::class, 'show']);
    Route::get('/dashboard-stats', DashboardController::class);
});
