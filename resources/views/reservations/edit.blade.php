@extends('layouts.app')
@section('title', 'Modifier statut réservation')

@section('content')

<div style="max-width:640px; margin:0 auto;">

    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('reservations.index') }}" style="color:#6366f1; text-decoration:none; font-size:0.875rem;">← Retour aux réservations</a>
    </div>

    <div class="cr-card">
        <div style="background:linear-gradient(135deg,#f59e0b,#d97706); padding:1.25rem 1.5rem; color:white;">
            <h1 style="font-size:1.25rem; font-weight:800; margin:0;">✏️ Modifier la réservation</h1>
            <p style="margin:6px 0 0; opacity:0.85; font-size:0.85rem;">{{ $reservation->trajet->ville_depart }} → {{ $reservation->trajet->ville_arrivee }}</p>
        </div>

        <div style="padding:1.75rem;">
            <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                    <div>
                        <label class="cr-label">Passager</label>
                        <input type="text" class="cr-input" value="{{ $reservation->passager->name }}" readonly style="background:#f1f5f9;">
                    </div>
                    <div>
                        <label class="cr-label">Conducteur</label>
                        <input type="text" class="cr-input" value="{{ $reservation->trajet->conducteur->name }}" readonly style="background:#f1f5f9;">
                    </div>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="cr-label">Horaire du trajet</label>
                    <input type="text" class="cr-input" value="{{ $reservation->trajet->horaire->format('d/m/Y à H:i') }}" readonly style="background:#f1f5f9;">
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label class="cr-label">Nouveau Statut <span style="color:#ef4444;">*</span></label>
                    <select name="statut" class="cr-input" required>
                        <option value="en_attente" {{ old('statut', $reservation->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmee" {{ old('statut', $reservation->statut) == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                        <option value="refusee" {{ old('statut', $reservation->statut) == 'refusee' ? 'selected' : '' }}>Refusée</option>
                        <option value="annulee" {{ old('statut', $reservation->statut) == 'annulee' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>

                <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:10px; padding:1rem; margin-bottom:1.5rem; font-size:0.8rem; color:#92400e;">
                    ⚠️ Les réservations confirmées, refusées ou annulées ne peuvent pas être réinitialisées en attente.
                </div>

                <div style="display:flex; gap:0.75rem; justify-content:flex-end;">
                    <a href="{{ route('reservations.index') }}" class="btn-cr-secondary">Annuler</a>
                    <button type="submit" class="btn-cr-warning">💾 Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection