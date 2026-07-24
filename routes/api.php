<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('trajets', TrajetController::class);

    Route::apiResource('reservations', ReservationController::class);

});