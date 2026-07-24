@extends('layouts.app')
@section('title', 'Modifier un trajet')

@section('content')

<div style="max-width:640px; margin:0 auto;">

    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('trajets.show', $trajet) }}" style="color:#6366f1; text-decoration:none; font-size:0.875rem;">← Retour au trajet</a>
    </div>

    <div class="cr-card">
        <div style="background:linear-gradient(135deg,#f59e0b,#d97706); padding:1.25rem 1.5rem; color:white;">
            <h1 style="font-size:1.25rem; font-weight:800; margin:0;">✏️ Modifier le trajet</h1>
            <p style="margin:6px 0 0; opacity:0.85; font-size:0.85rem;">{{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}</p>
        </div>

        <div style="padding:1.75rem;">
            <form action="{{ route('trajets.update', $trajet) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                    <div>
                        <label class="cr-label">📍 Ville de départ</label>
                        <input type="text" name="ville_depart" class="cr-input"
                            value="{{ old('ville_depart', $trajet->ville_depart) }}" required>
                    </div>
                    <div>
                        <label class="cr-label">🏁 Ville d'arrivée</label>
                        <input type="text" name="ville_arrivee" class="cr-input"
                            value="{{ old('ville_arrivee', $trajet->ville_arrivee) }}" required>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                    <div>
                        <label class="cr-label">🕐 Date et horaire</label>
                        <input type="datetime-local" name="horaire" class="cr-input"
                            value="{{ old('horaire', $trajet->horaire->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div>
                        <label class="cr-label">🪑 Places disponibles</label>
                        <input type="number" name="places_disponibles" class="cr-input" min="1" max="8"
                            value="{{ old('places_disponibles', $trajet->places_disponibles) }}" required>
                    </div>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label class="cr-label">📅 Jours de récurrence</label>
                    <input type="text" name="jours_recurrence" class="cr-input"
                        placeholder="ex: Lundi, Mercredi, Vendredi"
                        value="{{ old('jours_recurrence', $trajet->jours_recurrence) }}">
                </div>

                <div style="display:flex; gap:0.75rem; justify-content:flex-end;">
                    <a href="{{ route('trajets.show', $trajet) }}" class="btn-cr-secondary">Annuler</a>
                    <button type="submit" class="btn-cr-primary" style="background:linear-gradient(135deg,#f59e0b,#d97706); box-shadow:0 4px 15px rgba(245,158,11,0.35);">
                        💾 Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection