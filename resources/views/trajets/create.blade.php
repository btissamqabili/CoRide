@extends('layouts.app')
@section('title', 'Publier un trajet')

@section('content')

<div style="max-width:640px; margin:0 auto;">

    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('trajets.index') }}" style="color:#6366f1; text-decoration:none; font-size:0.875rem;">← Retour aux trajets</a>
    </div>

    <div class="cr-card">
        <div class="cr-card-header">
            <h1 style="font-size:1.25rem; font-weight:800; margin:0; color:white;">🚗 Publier un nouveau trajet</h1>
            <p style="margin:6px 0 0; opacity:0.8; font-size:0.85rem;">Partagez votre trajet quotidien avec vos collègues</p>
        </div>

        <div style="padding:1.75rem;">
            <form action="{{ route('trajets.store') }}" method="POST">
                @csrf

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                    <div>
                        <label class="cr-label">📍 Ville de départ <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="ville_depart" class="cr-input" placeholder="ex: Lyon"
                            value="{{ old('ville_depart') }}" required>
                    </div>
                    <div>
                        <label class="cr-label">🏁 Ville d'arrivée <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="ville_arrivee" class="cr-input" placeholder="ex: Villeurbanne"
                            value="{{ old('ville_arrivee') }}" required>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                    <div>
                        <label class="cr-label">🕐 Date et horaire <span style="color:#ef4444;">*</span></label>
                        <input type="datetime-local" name="horaire" class="cr-input"
                            value="{{ old('horaire') }}" required>
                    </div>
                    <div>
                        <label class="cr-label">🪑 Places disponibles <span style="color:#ef4444;">*</span></label>
                        <input type="number" name="places_disponibles" class="cr-input" min="1" max="8"
                            value="{{ old('places_disponibles', 2) }}" required>
                    </div>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label class="cr-label">📅 Jours de récurrence</label>
                    <input type="text" name="jours_recurrence" class="cr-input"
                        placeholder="ex: Lundi, Mercredi, Vendredi"
                        value="{{ old('jours_recurrence') }}">
                    <p style="font-size:0.75rem; color:#94a3b8; margin:6px 0 0;">Indiquez les jours où vous effectuez ce trajet régulièrement</p>
                </div>

                <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:10px; padding:1rem; margin-bottom:1.5rem; font-size:0.8rem; color:#0c4a6e;">
                    💡 En publiant ce trajet, les passagers de CoRide pourront le voir et calculer leur score de compatibilité IA.
                </div>

                <div style="display:flex; gap:0.75rem; justify-content:flex-end;">
                    <a href="{{ route('trajets.index') }}" class="btn-cr-secondary">Annuler</a>
                    <button type="submit" class="btn-cr-primary">🚀 Publier le trajet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection