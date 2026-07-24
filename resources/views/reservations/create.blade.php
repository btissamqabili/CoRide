@extends('layouts.app')
@section('title', 'Nouvelle réservation')

@section('content')

<div style="max-width:640px; margin:0 auto;">

    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('reservations.index') }}" style="color:#6366f1; text-decoration:none; font-size:0.875rem;">← Retour aux réservations</a>
    </div>

    <div class="cr-card">
        <div style="background:linear-gradient(135deg,#10b981,#059669); padding:1.25rem 1.5rem; color:white;">
            <h1 style="font-size:1.25rem; font-weight:800; margin:0;">📋 Réserver un trajet</h1>
            <p style="margin:6px 0 0; opacity:0.85; font-size:0.85rem;">Sélectionnez le trajet auquel vous souhaitez vous joindre</p>
        </div>

        <div style="padding:1.75rem;">

            @if($trajets->count() > 0)
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf

                    <div style="margin-bottom:1.5rem;">
                        <label class="cr-label">Choisir un trajet disponible <span style="color:#ef4444;">*</span></label>
                        <select name="trajet_id" class="cr-input" required>
                            <option value="">-- Sélectionner un trajet --</option>
                            @foreach($trajets as $trajet)
                                @php $rest = $trajet->placesRestantes(); @endphp
                                <option value="{{ $trajet->id }}"
                                    {{ (old('trajet_id', $trajetSelectionne?->id) == $trajet->id) ? 'selected' : '' }}>
                                    {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
                                    | 👤 Conducteur: {{ $trajet->conducteur->name }}
                                    | 🕐 {{ $trajet->horaire->format('d/m/Y H:i') }}
                                    | Places rest: {{ $rest }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="background:#f0fdf4; border:1px solid #86efac; border-radius:10px; padding:1rem; margin-bottom:1.5rem; font-size:0.825rem; color:#166534;">
                        ℹ️ Votre demande de réservation sera transmise au conducteur sous le statut <strong>En attente</strong>.
                    </div>

                    <div style="display:flex; gap:0.75rem; justify-content:flex-end;">
                        <a href="{{ route('reservations.index') }}" class="btn-cr-secondary">Annuler</a>
                        <button type="submit" class="btn-cr-success">
                            ✓ Envoyer la demande
                        </button>
                    </div>
                </form>
            @else
                <div style="text-align:center; padding:2rem 0;">
                    <div style="font-size:2.5rem; margin-bottom:1rem;">🚗</div>
                    <h3 style="font-weight:700; color:#374151;">Aucun trajet disponible</h3>
                    <p style="color:#64748b; font-size:0.875rem;">Tous les trajets sont complets ou vous êtes le conducteur de tous les trajets actuels.</p>
                    <a href="{{ route('trajets.index') }}" class="btn-cr-primary" style="margin-top:1rem;">Voir la liste des trajets</a>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection