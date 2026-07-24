<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Supporter à la fois l'authentification Sanctum (API token) et Session Web (Navigateur)
Route::middleware(['web', 'auth'])->group(function () {
    Route::apiResource('trajets', TrajetController::class);
    Route::apiResource('reservations', ReservationController::class);
});