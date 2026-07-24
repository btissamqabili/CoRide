@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')

@php
    $userRole      = auth()->user()->role;
    $estPassager   = in_array($userRole, ['passager', 'les_deux']);
    $estConducteur = in_array($userRole, ['conducteur', 'les_deux']);
@endphp

{{-- Page header --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
    <div>
        <h1 style="font-size:1.75rem; font-weight:800; color:#0f172a; margin:0 0 0.25rem; letter-spacing:-0.5px;">
            Bonjour, {{ auth()->user()->name }} 👋
        </h1>
        <p style="color:#64748b; margin:0; font-size:0.9rem;">
            {{ auth()->user()->entreprise->nom ?? '' }} ·
            <span style="font-weight:600; color:#e11d48;">
                {{ $userRole === 'conducteur' ? 'Conducteur' : ($userRole === 'passager' ? 'Passager' : 'Conducteur & Passager') }}
            </span>
            · 📍 {{ auth()->user()->ville_residence }}
        </p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        @if($estConducteur)
            <a href="{{ route('trajets.create') }}" class="btn-cr-primary">＋ Publier un trajet</a>
        @endif
        @if($estPassager)
            <a href="{{ route('trajets.index', ['avec_score' => 1]) }}" class="btn-cr-secondary">
                🤖 Trouver un trajet (IA)
            </a>
        @endif
    </div>
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:1.25rem; margin-bottom:2rem;">

    <div class="cr-card" style="padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
            <span style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8;">Trajets</span>
            <div style="width:40px; height:40px; background:#fff1f2; border:1px solid #fda4af; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">🗺️</div>
        </div>
        <p style="font-size:2.5rem; font-weight:800; color:#e11d48; margin:0; line-height:1;">{{ $nbTrajets }}</p>
        <a href="{{ route('trajets.index') }}" style="font-size:0.78rem; color:#94a3b8; text-decoration:none; margin-top:0.5rem; display:block; transition:color 0.2s;" onmouseover="this.style.color='#e11d48'" onmouseout="this.style.color='#94a3b8'">Rechercher un trajet →</a>
    </div>

    <div class="cr-card" style="padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
            <span style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8;">Réservations</span>
            <div style="width:40px; height:40px; background:#f0fdf4; border:1px solid #6ee7b7; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">📋</div>
        </div>
        <p style="font-size:2.5rem; font-weight:800; color:#059669; margin:0; line-height:1;">{{ $nbReservations }}</p>
        <a href="{{ route('reservations.index') }}" style="font-size:0.78rem; color:#94a3b8; text-decoration:none; margin-top:0.5rem; display:block; transition:color 0.2s;" onmouseover="this.style.color='#e11d48'" onmouseout="this.style.color='#94a3b8'">
            {{ $userRole === 'conducteur' ? 'Demandes reçues →' : 'Mes réservations →' }}
        </a>
    </div>

    <div class="cr-card" style="padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
            <span style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8;">Collaborateurs</span>
            <div style="width:40px; height:40px; background:#fef3c7; border:1px solid #fde68a; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">👥</div>
        </div>
        <p style="font-size:2.5rem; font-weight:800; color:#d97706; margin:0; line-height:1;">{{ $nbEmployes }}</p>
        <span style="font-size:0.78rem; color:#94a3b8; margin-top:0.5rem; display:block;">Inscrits sur CoRide</span>
    </div>

    <div class="cr-card" style="padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
            <span style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8;">Entreprises</span>
            <div style="width:40px; height:40px; background:#fff1f2; border:1px solid #fda4af; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">🏢</div>
        </div>
        <p style="font-size:2.5rem; font-weight:800; color:#e11d48; margin:0; line-height:1;">{{ $nbEntreprises }}</p>
        <span style="font-size:0.78rem; color:#94a3b8; margin-top:0.5rem; display:block;">Réseau partenaire</span>
    </div>

</div>

{{-- Actions & Profil --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:1.5rem;">

    @if($estConducteur)
    <div class="cr-card" style="padding:1.75rem;">
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:1.25rem;">
            <div style="width:38px; height:38px; background:#fff1f2; border:1px solid #fda4af; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem;">🚘</div>
            <h2 style="font-size:0.975rem; font-weight:700; color:#0f172a; margin:0;">Espace Conducteur</h2>
        </div>
        <div style="display:flex; flex-direction:column; gap:0.625rem;">
            <a href="{{ route('trajets.create') }}" class="btn-cr-primary" style="justify-content:center;">
                ＋ Publier un nouveau trajet
            </a>
            <a href="{{ route('trajets.mes-trajets') }}" class="btn-cr-secondary" style="justify-content:center;">
                Mes trajets publiés
            </a>
            <a href="{{ route('reservations.index', ['vue' => 'conducteur']) }}" class="btn-cr-secondary" style="justify-content:center;">
                Demandes de réservation reçues
            </a>
        </div>
    </div>
    @endif

    @if($estPassager)
    <div class="cr-card" style="padding:1.75rem;">
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:1.25rem;">
            <div style="width:38px; height:38px; background:#fff1f2; border:1px solid #fda4af; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem;">🧳</div>
            <h2 style="font-size:0.975rem; font-weight:700; color:#0f172a; margin:0;">Espace Passager</h2>
        </div>
        <div style="display:flex; flex-direction:column; gap:0.625rem;">
            <a href="{{ route('trajets.index', ['avec_score' => 1]) }}" class="btn-cr-primary" style="justify-content:center;">
                🤖 Trouver un trajet (Score IA)
            </a>
            <a href="{{ route('trajets.index') }}" class="btn-cr-secondary" style="justify-content:center;">
                Parcourir tous les trajets
            </a>
            <a href="{{ route('reservations.index', ['vue' => 'passager']) }}" class="btn-cr-secondary" style="justify-content:center;">
                Mes demandes de réservation
            </a>
        </div>
    </div>
    @endif

    <div class="cr-card" style="padding:1.75rem; grid-column:1 / -1;">
        <h2 style="font-size:0.975rem; font-weight:700; color:#0f172a; margin:0 0 1.25rem;">Mon Profil Salarié</h2>
        <div style="display:flex; align-items:center; gap:1.5rem; flex-wrap:wrap;">
            <div class="cr-avatar" style="width:56px; height:56px; font-size:1.4rem; font-weight:800; box-shadow:0 4px 16px rgba(225,29,72,0.25);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="flex:1;">
                <div style="font-weight:700; font-size:1rem; color:#0f172a; margin-bottom:2px;">{{ auth()->user()->name }}</div>
                <div style="color:#64748b; font-size:0.85rem; margin-bottom:0.625rem;">{{ auth()->user()->email }}</div>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <span style="background:#fff1f2; color:#9f1239; border:1px solid #fda4af; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:600;">
                        {{ $userRole === 'conducteur' ? 'Conducteur' : ($userRole === 'passager' ? 'Passager' : 'Conducteur & Passager') }}
                    </span>
                    <span style="background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:600;">
                        🏢 {{ auth()->user()->entreprise->nom ?? 'N/A' }}
                    </span>
                    <span style="background:#f0fdf4; color:#166534; border:1px solid #6ee7b7; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:600;">
                        📍 {{ auth()->user()->ville_residence }}
                    </span>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn-cr-secondary" style="flex-shrink:0;">Modifier profil</a>
        </div>
    </div>

</div>

@endsection