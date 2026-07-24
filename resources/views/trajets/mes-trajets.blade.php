@extends('layouts.app')
@section('title', 'Mes trajets')

@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
    <div>
        <h1 style="font-size:1.6rem; font-weight:800; color:#0f172a; margin:0;">🚘 Mes trajets publiés</h1>
        <p style="color:#64748b; margin:0.25rem 0 0; font-size:0.875rem;">{{ $trajets->count() }} trajet{{ $trajets->count() > 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('trajets.create') }}" class="btn-cr-primary">＋ Publier un trajet</a>
</div>

@if($trajets->count() > 0)

    <div style="display:flex; flex-direction:column; gap:1.25rem;">
        @foreach($trajets as $trajet)
        @php
            $restantes  = $trajet->placesRestantes();
            $nbAttente  = $trajet->reservations->where('statut','en_attente')->count();
            $nbConfirm  = $trajet->reservations->where('statut','confirmee')->count();
            $nbRefusee  = $trajet->reservations->where('statut','refusee')->count();
            $nbAnnulee  = $trajet->reservations->where('statut','annulee')->count();
        @endphp

        <div class="cr-card">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:1.1rem 1.5rem; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:15px 15px 0 0;">
                <div>
                    <div style="font-size:1.1rem; font-weight:700; color:white;">
                        {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
                    </div>
                    <div style="font-size:0.8rem; color:rgba(255,255,255,0.8); margin-top:3px;">
                        🕐 {{ $trajet->horaire->format('d/m/Y à H:i') }}
                        @if($trajet->jours_recurrence)
                            · 📅 {{ $trajet->jours_recurrence }}
                        @endif
                    </div>
                </div>
                <div style="display:flex; gap:6px; align-items:center;">
                    <div style="background:rgba(255,255,255,0.2); color:white; padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:600;">
                        🪑 {{ $restantes }}/{{ $trajet->places_disponibles }} places
                    </div>
                </div>
            </div>

            <div style="padding:1.25rem 1.5rem;">

                {{-- Stats réservations --}}
                <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:0.75rem; margin-bottom:1.25rem;">
                    <div style="text-align:center; padding:0.75rem; background:#fef9c3; border-radius:10px;">
                        <div style="font-size:1.25rem; font-weight:800; color:#92400e;">{{ $nbAttente }}</div>
                        <div style="font-size:0.7rem; color:#78350f; font-weight:600;">En attente</div>
                    </div>
                    <div style="text-align:center; padding:0.75rem; background:#d1fae5; border-radius:10px;">
                        <div style="font-size:1.25rem; font-weight:800; color:#065f46;">{{ $nbConfirm }}</div>
                        <div style="font-size:0.7rem; color:#064e3b; font-weight:600;">Confirmées</div>
                    </div>
                    <div style="text-align:center; padding:0.75rem; background:#fee2e2; border-radius:10px;">
                        <div style="font-size:1.25rem; font-weight:800; color:#7f1d1d;">{{ $nbRefusee }}</div>
                        <div style="font-size:0.7rem; color:#6b1a1a; font-weight:600;">Refusées</div>
                    </div>
                    <div style="text-align:center; padding:0.75rem; background:#f1f5f9; border-radius:10px;">
                        <div style="font-size:1.25rem; font-weight:800; color:#475569;">{{ $nbAnnulee }}</div>
                        <div style="font-size:0.7rem; color:#334155; font-weight:600;">Annulées</div>
                    </div>
                </div>

                {{-- Passagers en attente --}}
                @if($nbAttente > 0)
                <div style="margin-bottom:1rem;">
                    <h4 style="font-size:0.8rem; font-weight:700; color:#92400e; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.5rem;">
                        ⏳ Demandes en attente
                    </h4>
                    @foreach($trajet->reservations->where('statut','en_attente') as $res)
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem 1rem; background:#fffbeb; border:1px solid #fbbf24; border-radius:8px; margin-bottom:0.5rem;">
                        <div>
                            <span style="font-weight:600; font-size:0.875rem; color:#374151;">{{ $res->passager->name }}</span>
                            <span style="color:#64748b; font-size:0.8rem; margin-left:8px;">{{ $res->passager->ville_residence }}</span>
                        </div>
                        <div style="display:flex; gap:6px;">
                            <form method="POST" action="{{ route('reservations.statut', $res) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="statut" value="confirmee">
                                <button type="submit" class="btn-cr-success" style="padding:4px 12px; font-size:0.75rem;">✓ Confirmer</button>
                            </form>
                            <form method="POST" action="{{ route('reservations.statut', $res) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="statut" value="refusee">
                                <button type="submit" class="btn-cr-danger" style="padding:4px 12px; font-size:0.75rem;">✕ Refuser</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Actions --}}
                <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                    <a href="{{ route('trajets.show', $trajet) }}" class="btn-cr-info" style="font-size:0.8rem; padding:0.45rem 1rem;">👁 Voir détails</a>
                    <a href="{{ route('trajets.edit', $trajet) }}" class="btn-cr-warning" style="font-size:0.8rem; padding:0.45rem 1rem;">✏️ Modifier</a>
                    @if($trajet->reservations->where('statut','confirmee')->count() === 0)
                    <form action="{{ route('trajets.destroy', $trajet) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-cr-danger" style="font-size:0.8rem; padding:0.45rem 1rem;"
                            onclick="return confirm('Supprimer ce trajet ?')">🗑 Supprimer</button>
                    </form>
                    @else
                    <span style="font-size:0.75rem; color:#94a3b8; display:flex; align-items:center;">🔒 Suppression impossible (réservations confirmées)</span>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    </div>

@else
    <div class="cr-card" style="padding:3rem; text-align:center;">
        <div style="font-size:3rem; margin-bottom:1rem;">🚗</div>
        <h3 style="font-size:1.1rem; font-weight:700; color:#374151; margin-bottom:0.5rem;">Vous n'avez pas encore publié de trajet</h3>
        <p style="color:#64748b; font-size:0.9rem; margin-bottom:1.5rem;">Partagez votre trajet quotidien avec vos collègues !</p>
        <a href="{{ route('trajets.create') }}" class="btn-cr-primary">🚀 Publier mon premier trajet</a>
    </div>
@endif

@endsection
