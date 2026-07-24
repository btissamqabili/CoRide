<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Http\Requests\StoreTrajetRequest;
use App\Http\Requests\UpdateTrajetRequest;
use App\Services\CompatibiliteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrajetController extends Controller
{
    /**
     * Afficher la liste des trajets avec recherche et score IA.
     */
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = Trajet::with(['conducteur.entreprise', 'reservations']);

        // Filtrage par ville de départ
        if ($request->filled('ville_depart')) {
            $query->where('ville_depart', 'like', '%' . $request->ville_depart . '%');
        }

        // Filtrage par ville d'arrivée
        if ($request->filled('ville_arrivee')) {
            $query->where('ville_arrivee', 'like', '%' . $request->ville_arrivee . '%');
        }

        // Exclure les trajets complets si demandé
        if ($request->boolean('places_dispo')) {
            $query->whereRaw('places_disponibles > (
                SELECT COUNT(*) FROM reservations
                WHERE reservations.trajet_id = trajets.id
                AND reservations.statut = "confirmee"
            )');
        }

        $trajets = $query->orderBy('horaire')->get();

        // Calcul du score IA pour chaque trajet
        $scoresIA = [];

        if ($user && $request->boolean('avec_score')) {
            $service = app(CompatibiliteService::class);
            foreach ($trajets as $trajet) {
                if ($trajet->conducteur_id !== $user->id) {
                    $scoresIA[$trajet->id] = $service->calculer($trajet, $user);
                }
            }
            $trajets = $trajets->sortByDesc(fn($t) => $scoresIA[$t->id]['score'] ?? -1)->values();
        }

        return view('trajets.index', compact('trajets', 'scoresIA'));
    }

    /**
     * Afficher le formulaire de création (Conducteur / Les Deux uniquement).
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'passager') {
            return redirect()->route('dashboard')
                ->with('error', 'Accès refusé : En tant que passager uniquement, vous ne pouvez pas publier de trajet.');
        }

        return view('trajets.create');
    }

    /**
     * Enregistrer un nouveau trajet (Conducteur / Les Deux uniquement).
     */
    public function store(StoreTrajetRequest $request)
    {
        $user = Auth::user();

        if ($user->role === 'passager') {
            return redirect()->route('dashboard')
                ->with('error', 'Accès refusé : En tant que passager uniquement, vous ne pouvez pas publier de trajet.');
        }

        Trajet::create([
            'conducteur_id'      => $user->id,
            'ville_depart'       => $request->ville_depart,
            'ville_arrivee'      => $request->ville_arrivee,
            'horaire'            => $request->horaire,
            'places_disponibles' => $request->places_disponibles,
            'jours_recurrence'   => $request->jours_recurrence,
        ]);

        return redirect()->route('trajets.mes-trajets')
            ->with('success', 'Trajet publié avec succès !');
    }

    /**
     * Afficher le détail d'un trajet.
     */
    public function show(Trajet $trajet, Request $request)
    {
        $trajet->load(['conducteur.entreprise', 'reservations.passager']);

        $scoreIA = null;
        $user    = Auth::user();

        if ($request->boolean('score') && $user && $trajet->conducteur_id !== $user->id) {
            $service = app(CompatibiliteService::class);
            $scoreIA = $service->calculer($trajet, $user);
        }

        return view('trajets.show', compact('trajet', 'scoreIA'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Trajet $trajet)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['conducteur', 'les_deux']) || $trajet->conducteur_id !== $user->id) {
            return redirect()->route('trajets.index')
                ->with('error', 'Vous ne pouvez modifier que vos propres trajets.');
        }

        return view('trajets.edit', compact('trajet'));
    }

    /**
     * Mettre à jour un trajet.
     */
    public function update(UpdateTrajetRequest $request, Trajet $trajet)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['conducteur', 'les_deux']) || $trajet->conducteur_id !== $user->id) {
            return redirect()->route('trajets.index')
                ->with('error', 'Vous ne pouvez modifier que vos propres trajets.');
        }

        $trajet->update($request->validated());

        return redirect()->route('trajets.show', $trajet)
            ->with('success', 'Trajet modifié avec succès.');
    }

    /**
     * Supprimer un trajet.
     */
    public function destroy(Trajet $trajet)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['conducteur', 'les_deux']) || $trajet->conducteur_id !== $user->id) {
            return redirect()->route('trajets.index')
                ->with('error', 'Vous ne pouvez supprimer que vos propres trajets.');
        }

        // Règle métier : pas de suppression si réservations confirmées
        if ($trajet->reservations()->where('statut', 'confirmee')->exists()) {
            return redirect()->route('trajets.index')
                ->with('error', 'Impossible de supprimer ce trajet : il possède des réservations confirmées.');
        }

        $trajet->delete();

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet supprimé avec succès.');
    }

    /**
     * Tableau de bord conducteur : mes trajets publiés.
     */
    public function mesTorajets()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['conducteur', 'les_deux'])) {
            return redirect()->route('dashboard')
                ->with('error', 'Accès refusé : la page Mes Trajets est réservée aux conducteurs.');
        }

        $trajets = Trajet::with(['reservations.passager'])
            ->where('conducteur_id', $user->id)
            ->orderBy('horaire')
            ->get();

        return view('trajets.mes-trajets', compact('trajets'));
    }

    /**
     * Calculer et afficher le score IA pour un trajet donné.
     */
    public function score(Trajet $trajet, Request $request)
    {
        $user = Auth::user();

        if ($trajet->conducteur_id === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas calculer un score pour votre propre trajet.');
        }

        $service = app(CompatibiliteService::class);
        $scoreIA = $service->calculer($trajet, $user);

        return redirect()->route('trajets.show', ['trajet' => $trajet, 'score' => 1])
            ->with('score_ia_result', $scoreIA);
    }
}