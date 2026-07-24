@extends('layouts.app')
@section('title', 'Détails de la réservation')

@section('content')

<div style="max-width:680px; margin:0 auto;">

    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('reservations.index') }}" style="color:#6366f1; text-decoration:none; font-size:0.875rem;">← Retour aux réservations</a>
    </div>

    <div class="cr-card">
        <div class="cr-card-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h1 style="font-size:1.25rem; font-weight:800; margin:0; color:white;">Détails de la réservation #{{ $reservation->id }}</h1>
                <p style="margin:4px 0 0; opacity:0.85; font-size:0.85rem;">{{ $reservation->trajet->ville_depart }} → {{ $reservation->trajet->ville_arrivee }}</p>
            </div>
            <span class="badge-{{ $reservation->statut }}" style="font-size:0.85rem; padding:6px 14px;">
                {{ ['en_attente'=>'En attente','confirmee'=>'Confirmée','refusee'=>'Refusée','annulee'=>'Annulée'][$reservation->statut] }}
            </span>
        </div>

        <div style="padding:1.75rem;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.5rem;">
                <div style="background:#f8fafc; padding:1rem; border-radius:12px;">
                    <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; color:#94a3b8; margin-bottom:6px;">Passager</div>
                    <div style="font-weight:700; color:#0f172a;">{{ $reservation->passager->name }}</div>
                    <div style="font-size:0.8rem; color:#64748b;">{{ $reservation->passager->email }}</div>
                    <div style="font-size:0.8rem; color:#64748b;">🏢 {{ $reservation->passager->entreprise->nom ?? 'N/A' }}</div>
                    <div style="font-size:0.8rem; color:#64748b;">📍 {{ $reservation->passager->ville_residence }}</div>
                </div>

                <div style="background:#f8fafc; padding:1rem; border-radius:12px;">
                    <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; color:#94a3b8; margin-bottom:6px;">Conducteur</div>
                    <div style="font-weight:700; color:#0f172a;">{{ $reservation->trajet->conducteur->name }}</div>
                    <div style="font-size:0.8rem; color:#64748b;">{{ $reservation->trajet->conducteur->email }}</div>
                    <div style="font-size:0.8rem; color:#64748b;">🏢 {{ $reservation->trajet->conducteur->entreprise->nom ?? 'N/A' }}</div>
                </div>
            </div>

            <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:12px; padding:1.25rem; margin-bottom:1.5rem;">
                <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; color:#0369a1; margin-bottom:8px;">Informations Trajet</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; font-size:0.875rem;">
                    <div>
                        <span style="color:#64748b;">Itinéraire :</span>
                        <strong style="color:#0c4a6e;">{{ $reservation->trajet->ville_depart }} → {{ $reservation->trajet->ville_arrivee }}</strong>
                    </div>
                    <div>
                        <span style="color:#64748b;">Horaire :</span>
                        <strong style="color:#0c4a6e;">{{ $reservation->trajet->horaire->format('d/m/Y à H:i') }}</strong>
                    </div>
                    <div>
                        <span style="color:#64748b;">Capacity :</span>
                        <strong style="color:#0c4a6e;">{{ $reservation->trajet->places_disponibles }} places totales</strong>
                    </div>
                    <div>
                        <span style="color:#64748b;">Date demande :</span>
                        <strong style="color:#0c4a6e;">{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center;">
                <a href="{{ route('reservations.index') }}" class="btn-cr-secondary">← Retour</a>
                <div style="display:flex; gap:8px;">
                    <a href="{{ route('reservations.edit', $reservation) }}" class="btn-cr-warning">✏️ Modifier statut</a>
                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-cr-danger" onclick="return confirm('Supprimer cette réservation ?')">🗑 Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection