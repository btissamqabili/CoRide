<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Http\Requests\StoreTrajetRequest;
use App\Http\Requests\UpdateTrajetRequest;
use Illuminate\Support\Facades\Auth;

class TrajetController extends Controller
{
    /**
     * Afficher la liste des trajets.
     */
    public function index()
    {
        $trajets = Trajet::all();

        return view('trajets.index', compact('trajets'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('trajets.create');
    }

    /**
     * Enregistrer un nouveau trajet.
     */
    public function store(StoreTrajetRequest $request)
    {
        Trajet::create([
            'conducteur_id' => Auth::id(),
            'ville_depart' => $request->ville_depart,
            'ville_arrivee' => $request->ville_arrivee,
            'horaire' => $request->horaire,
            'places_disponibles' => $request->places_disponibles,
            'jours_recurrence' => $request->jours_recurrence,
        ]);

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet ajouté avec succès.');
    }

    /**
     * Afficher le détail d'un trajet.
     */
    public function show(Trajet $trajet)
    {
        return view('trajets.show', compact('trajet'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Trajet $trajet)
    {
        return view('trajets.edit', compact('trajet'));
    }

    /**
     * Mettre à jour un trajet.
     */
    public function update(UpdateTrajetRequest $request, Trajet $trajet)
    {
        $trajet->update($request->validated());

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet modifié avec succès.');
    }

    /**
     * Supprimer un trajet.
     */
    public function destroy(Trajet $trajet)
{
    // Vérifier s'il existe des réservations confirmées
    if ($trajet->reservations()
        ->where('statut', 'confirmee')
        ->exists()) {

        return redirect()->route('trajets.index')
            ->with('error', 'Impossible de supprimer ce trajet car il possède des réservations confirmées.');
    }

    // Supprimer le trajet
    $trajet->delete();

    return redirect()->route('trajets.index')
        ->with('success', 'Trajet supprimé avec succès.');
}
}