<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'nbTrajets' => Trajet::count(),
            'nbReservations' => Reservation::count(),
            'nbEmployes' => User::count(),
            'nbEntreprises' => Entreprise::count(),
        ]);
    }
}