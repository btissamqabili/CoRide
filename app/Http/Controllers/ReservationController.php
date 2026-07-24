<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trajet;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Afficher toutes les réservations de l'utilisateur selon son rôle.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'conducteur') {
            // Conducteur pur : voir uniquement les réservations reçues sur ses trajets
            $reservations = Reservation::with(['trajet', 'passager.entreprise'])
                ->whereHas('trajet', fn($q) => $q->where('conducteur_id', $user->id))
                ->orderBy('created_at', 'desc')
                ->get();
            $vueRole = 'conducteur';
        } elseif ($user->role === 'passager') {
            // Passager pur : voir uniquement ses propres demandes de réservation
            $reservations = Reservation::with(['trajet.conducteur.entreprise'])
                ->where('passager_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
            $vueRole = 'passager';
        } else {
            // Role 'les_deux' : voir ses demandes faites + les demandes reçues sur ses trajets
            $typeVue = $request->query('vue', 'passager');
            if ($typeVue === 'conducteur') {
                $reservations = Reservation::with(['trajet', 'passager.entreprise'])
                    ->whereHas('trajet', fn($q) => $q->where('conducteur_id', $user->id))
                    ->orderBy('created_at', 'desc')
                    ->get();
                $vueRole = 'conducteur';
            } else {
                $reservations = Reservation::with(['trajet.conducteur.entreprise'])
                    ->where('passager_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $vueRole = 'passager';
            }
        }

        return view('reservations.index', compact('reservations', 'vueRole'));
    }

    /**
     * Formulaire de réservation (Passager / Les Deux uniquement).
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'conducteur') {
            return redirect()->route('dashboard')
                ->with('error', 'Accès refusé : En tant que conducteur uniquement, vous ne pouvez pas effectuer de réservation.');
        }

        $trajetId = $request->query('trajet_id');
        $trajets  = Trajet::with('conducteur')
            ->whereRaw('places_disponibles > (
                SELECT COUNT(*) FROM reservations
                WHERE reservations.trajet_id = trajets.id
                AND reservations.statut = "confirmee"
            )')
            ->where('conducteur_id', '!=', $user->id)
            ->get();

        $trajetSelectionne = $trajetId ? Trajet::find($trajetId) : null;

        return view('reservations.create', compact('trajets', 'trajetSelectionne'));
    }

    /**
     * Enregistrer une réservation (Passager / Les Deux uniquement).
     */
    public function store(StoreReservationRequest $request)
    {
        $user = Auth::user();

        if ($user->role === 'conducteur') {
            return redirect()->route('dashboard')
                ->with('error', 'Accès refusé : En tant que conducteur uniquement, vous ne pouvez pas effectuer de réservation.');
        }

        $trajet = Trajet::findOrFail($request->trajet_id);

        if ($trajet->conducteur_id === $user->id) {
            return back()->withErrors(['trajet_id' => 'Vous ne pouvez pas réserver votre propre trajet.']);
        }

        // Vérifier doublon
        $reservationExiste = Reservation::where('trajet_id', $request->trajet_id)
            ->where('passager_id', $user->id)
            ->exists();

        if ($reservationExiste) {
            return back()->withErrors(['trajet_id' => 'Vous avez déjà réservé ce trajet.']);
        }

        // Vérifier capacité
        $reservationsConfirmees = $trajet->reservations()->where('statut', 'confirmee')->count();

        if ($reservationsConfirmees >= $trajet->places_disponibles) {
            return back()->withErrors(['trajet_id' => 'Ce trajet est complet, aucune place disponible.']);
        }

        Reservation::create([
            'trajet_id'        => $request->trajet_id,
            'passager_id'      => $user->id,
            'statut'           => 'en_attente',
            'date_reservation' => now(),
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Demande de réservation envoyée avec succès !');
    }

    /**
     * Afficher une réservation.
     */
    public function show(Reservation $reservation)
    {
        $user = Auth::user();

        // Seul le passager concerné ou le conducteur du trajet peut voir la réservation
        if ($reservation->passager_id !== $user->id && $reservation->trajet->conducteur_id !== $user->id) {
            return redirect()->route('reservations.index')
                ->with('error', 'Accès refusé à cette réservation.');
        }

        $reservation->load(['trajet.conducteur.entreprise', 'passager.entreprise']);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Formulaire de modification (Conducteur / Passager).
     */
    public function edit(Reservation $reservation)
    {
        $user = Auth::user();

        if ($reservation->passager_id !== $user->id && $reservation->trajet->conducteur_id !== $user->id) {
            return redirect()->route('reservations.index')
                ->with('error', 'Accès refusé.');
        }

        $reservation->load(['trajet.conducteur', 'passager.entreprise']);
        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Modifier une réservation.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        return $this->changerStatut($reservation, $request->statut);
    }

    /**
     * Action rapide de changement de statut.
     */
    public function updateStatut(Request $request, Reservation $reservation)
    {
        $request->validate([
            'statut' => 'required|in:confirmee,refusee,annulee',
        ]);

        return $this->changerStatut($reservation, $request->statut);
    }

    private function changerStatut(Reservation $reservation, string $nouveauStatut): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        // Contrôle des autorisations par action
        if (in_array($nouveauStatut, ['confirmee', 'refusee']) && $reservation->trajet->conducteur_id !== $user->id) {
            return back()->with('error', 'Seul le conducteur du trajet peut confirmer ou refuser cette demande.');
        }

        if ($nouveauStatut === 'annulee' && $reservation->passager_id !== $user->id && $reservation->trajet->conducteur_id !== $user->id) {
            return back()->with('error', 'Action non autorisée.');
        }

        // Transitions interdites
        $transitionsInterdites = [
            'confirmee' => ['en_attente'],
            'refusee'   => ['en_attente'],
            'annulee'   => ['en_attente'],
        ];

        if (isset($transitionsInterdites[$reservation->statut])
            && in_array($nouveauStatut, $transitionsInterdites[$reservation->statut])) {
            return back()->with('error', "Une réservation «{$reservation->statut}» ne peut pas revenir en attente.");
        }

        // Vérifier capacité si confirmation
        if ($nouveauStatut === 'confirmee') {
            $confirmees = $reservation->trajet->reservations()
                ->where('statut', 'confirmee')
                ->where('id', '!=', $reservation->id)
                ->count();

            if ($confirmees >= $reservation->trajet->places_disponibles) {
                return back()->with('error', 'Impossible de confirmer : le trajet est déjà complet.');
            }
        }

        $reservation->update(['statut' => $nouveauStatut]);

        return redirect()->route('reservations.index')
            ->with('success', 'Statut de la réservation mis à jour avec succès.');
    }

    /**
     * Supprimer une réservation.
     */
    public function destroy(Reservation $reservation)
    {
        $user = Auth::user();

        if ($reservation->passager_id !== $user->id && $reservation->trajet->conducteur_id !== $user->id) {
            return back()->with('error', 'Action non autorisée.');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation supprimée.');
    }
}