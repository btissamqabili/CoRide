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
        // Vérifier que le trajet existe
        $trajet = Trajet::findOrFail($request->trajet_id);

        // Vérifier que l'utilisateur n'a pas déjà réservé ce trajet
        $reservationExiste = Reservation::where('trajet_id', $request->trajet_id)
            ->where('passager_id', Auth::id())
            ->exists();

        if ($reservationExiste) {
            return back()->withErrors([
                'trajet_id' => 'Vous avez déjà réservé ce trajet.'
            ]);
        }

        // Vérifier que le trajet n'est pas complet
        $reservationsConfirmees = $trajet->reservations()
            ->where('statut', 'confirmee')
            ->count();

        if ($reservationsConfirmees >= $trajet->places_disponibles) {
            return back()->withErrors([
                'trajet_id' => 'Ce trajet est complet.'
            ]);
        }

        // Créer la réservation
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
    $nouveauStatut = $request->statut;

    // Interdire de revenir à "en_attente"
    if (
        $reservation->statut === 'confirmee' &&
        $nouveauStatut === 'en_attente'
    ) {
        return back()->with(
            'error',
            'Une réservation confirmée ne peut pas revenir en attente.'
        );
    }

    if (
        $reservation->statut === 'refusee' &&
        $nouveauStatut === 'en_attente'
    ) {
        return back()->with(
            'error',
            'Une réservation refusée ne peut pas revenir en attente.'
        );
    }

    if (
        $reservation->statut === 'annulee' &&
        $nouveauStatut === 'en_attente'
    ) {
        return back()->with(
            'error',
            'Une réservation annulée ne peut pas revenir en attente.'
        );
    }

    $reservation->update([
        'statut' => $nouveauStatut,
    ]);

    return redirect()
        ->route('reservations.index')
        ->with('success', 'Statut mis à jour avec succès.');
}

    /**
     * Supprimer une réservation.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation supprimée avec succès.');
    }
}