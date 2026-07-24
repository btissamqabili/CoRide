<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trajet;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Afficher toutes les réservations.
     */
    public function index()
    {
        $reservations = Reservation::all();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Afficher le formulaire de réservation.
     */
    public function create()
    {
        $trajets = Trajet::all();

        return view('reservations.create', compact('trajets'));
    }

    /**
     * Enregistrer une réservation.
     */
    public function store(StoreReservationRequest $request)
    {
        Reservation::create([
            'trajet_id' => $request->trajet_id,
            'passager_id' => Auth::id(),
            'statut' => 'en_attente',
            'date_reservation' => now(),
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Afficher une réservation.
     */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Modifier une réservation.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update($request->validated());

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation mise à jour.');
    }

    /**
     * Supprimer une réservation.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation supprimée.');
    }
}