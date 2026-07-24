@extends('layouts.app')
@section('title', 'Gestion des Réservations')

@section('content')

@php
    $userRole = auth()->user()->role;
    $estLesDeux = $userRole === 'les_deux';
@endphp

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
    <div>
        <h1 style="font-size:1.6rem; font-weight:800; color:#0f172a; margin:0;">
            📋 {{ $vueRole === 'conducteur' ? 'Demandes de Réservation Reçues (Conducteur)' : 'Mes Réservations (Passager)' }}
        </h1>
        <p style="color:#64748b; margin:0.25rem 0 0; font-size:0.875rem;">
            {{ $vueRole === 'conducteur' ? 'Gérez les demandes soumises par les passagers sur vos trajets' : 'Suivez le statut de vos demandes de réservation' }}
            · {{ $reservations->count() }} réservation{{ $reservations->count() > 1 ? 's' : '' }}
        </p>
    </div>

    @if(in_array($userRole, ['passager', 'les_deux']))
        <a href="{{ route('reservations.create') }}" class="btn-cr-primary">＋ Nouvelle réservation</a>
    @endif
</div>

{{-- Tabs pour le rôle 'les_deux' --}}
@if($estLesDeux)
<div style="display:flex; gap:8px; margin-bottom:1.5rem;">
    <a href="{{ route('reservations.index', ['vue' => 'passager']) }}"
       class="btn-cr-secondary {{ $vueRole === 'passager' ? 'active' : '' }}"
       style="{{ $vueRole === 'passager' ? 'background:#6366f1; color:white; border-color:#6366f1;' : '' }}">
        🧳 Mes réservations (Passager)
    </a>
    <a href="{{ route('reservations.index', ['vue' => 'conducteur']) }}"
       class="btn-cr-secondary {{ $vueRole === 'conducteur' ? 'active' : '' }}"
       style="{{ $vueRole === 'conducteur' ? 'background:#6366f1; color:white; border-color:#6366f1;' : '' }}">
        🚘 Demandes reçues (Conducteur)
    </a>
</div>
@endif

@if($reservations->count() > 0)

    <div class="cr-card" style="padding:0; overflow:hidden;">
        <div style="overflow-x:auto;">
            <table class="cr-table">
                <thead>
                    <tr>
                        <th>Passager</th>
                        <th>Conducteur</th>
                        <th>Trajet</th>
                        <th>Horaire Trajet</th>
                        <th>Statut</th>
                        <th>Date Demande</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td style="font-weight:600;">
                            {{ $reservation->passager->name }}
                            <div style="font-size:0.75rem; color:#64748b; font-weight:400;">
                                {{ $reservation->passager->entreprise->nom ?? '' }} · {{ $reservation->passager->ville_residence }}
                            </div>
                        </td>

                        <td style="font-weight:600;">
                            {{ $reservation->trajet->conducteur->name }}
                            <div style="font-size:0.75rem; color:#64748b; font-weight:400;">
                                {{ $reservation->trajet->conducteur->entreprise->nom ?? '' }}
                            </div>
                        </td>

                        <td>
                            <div style="font-weight:700; color:#6366f1;">
                                {{ $reservation->trajet->ville_depart }} → {{ $reservation->trajet->ville_arrivee }}
                            </div>
                        </td>

                        <td style="font-size:0.8rem; color:#475569;">
                            {{ $reservation->trajet->horaire->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <span class="badge-{{ $reservation->statut }}">
                                {{ ['en_attente'=>'En attente','confirmee'=>'Confirmée','refusee'=>'Refusée','annulee'=>'Annulée'][$reservation->statut] ?? $reservation->statut }}
                            </span>
                        </td>

                        <td style="font-size:0.8rem; color:#64748b;">
                            {{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y H:i') }}
                        </td>

                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; gap:6px; align-items:center;">
                                <a href="{{ route('reservations.show', $reservation) }}" class="btn-cr-info" style="padding:4px 10px; font-size:0.75rem;">
                                    👁 Voir
                                </a>

                                {{-- Seul le conducteur du trajet peut confirmer/refuser --}}
                                @if($reservation->trajet->conducteur_id === auth()->id() && $reservation->statut === 'en_attente')
                                    <form method="POST" action="{{ route('reservations.statut', $reservation) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="statut" value="confirmee">
                                        <button type="submit" class="btn-cr-success" style="padding:4px 10px; font-size:0.75rem;">✓ Confirmer</button>
                                    </form>
                                    <form method="POST" action="{{ route('reservations.statut', $reservation) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="statut" value="refusee">
                                        <button type="submit" class="btn-cr-danger" style="padding:4px 10px; font-size:0.75rem;">✕ Refuser</button>
                                    </form>
                                @endif

                                {{-- Seul le passager concerné peut annuler --}}
                                @if($reservation->passager_id === auth()->id() && in_array($reservation->statut, ['en_attente', 'confirmee']))
                                    <form method="POST" action="{{ route('reservations.statut', $reservation) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="statut" value="annulee">
                                        <button type="submit" class="btn-cr-secondary" style="padding:4px 10px; font-size:0.75rem; color:#ef4444; border-color:#fca5a5;"
                                            onclick="return confirm('Annuler cette réservation ?')">
                                            🚫 Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@else
    <div class="cr-card" style="padding:3rem; text-align:center;">
        <div style="font-size:3rem; margin-bottom:1rem;">📋</div>
        <h3 style="font-size:1.1rem; font-weight:700; color:#374151; margin-bottom:0.5rem;">Aucune réservation disponible</h3>
        <p style="color:#64748b; font-size:0.9rem; margin-bottom:1.5rem;">
            {{ $vueRole === 'conducteur' ? 'Vous n\'avez reçu aucune demande sur vos trajets pour le moment.' : 'Recherchez un trajet et effectuez votre première demande !' }}
        </p>
        @if(in_array($userRole, ['passager', 'les_deux']))
            <a href="{{ route('trajets.index') }}" class="btn-cr-primary">🔍 Rechercher un trajet</a>
        @endif
    </div>
@endif

@endsection