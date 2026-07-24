<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TrajetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIController;
use App\Http\Controllers\CompatibilityController;
/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Routes protégées
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Gestion des trajets (CRUD standard)
    Route::resource('trajets', TrajetController::class);

    // Routes spéciales trajets
    Route::get('/mes-trajets', [TrajetController::class, 'mesTorajets'])
        ->name('trajets.mes-trajets');

    Route::post('/trajets/{trajet}/score', [TrajetController::class, 'score'])
        ->name('trajets.score');

    // Gestion des réservations
    Route::resource('reservations', ReservationController::class);

    // Route dédiée pour changer le statut d'une réservation (action conducteur)
    Route::patch('/reservations/{reservation}/statut', [ReservationController::class, 'updateStatut'])
        ->name('reservations.statut');

    // Profil utilisateur (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::get('/ai-test', [AIController::class, 'test']);
Route::get('/compatibility/{reservation}', [CompatibilityController::class, 'show']);
});

require __DIR__.'/auth.php';