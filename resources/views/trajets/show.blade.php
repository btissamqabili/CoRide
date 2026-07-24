@extends('layouts.app')
@section('title', 'Détail du trajet')

@section('content')

@php
    $userRole    = auth()->user()->role;
    $estConducteur = in_array($userRole, ['conducteur', 'les_deux']);
    $restantes   = $trajet->placesRestantes();
    $estMien     = $trajet->conducteur_id === auth()->id();
    $dejaReserve = auth()->user()->reservations()->where('trajet_id', $trajet->id)->exists();
    $scoreResult = $scoreIA ?? session('score_ia_result');
@endphp

{{-- Breadcrumb --}}
<div style="margin-bottom:1.5rem; font-size:0.85rem; color:#94a3b8;">
    <a href="{{ route('trajets.index') }}" style="color:#6366f1; text-decoration:none;">← Retour aux trajets</a>
</div>

<div style="display:grid; grid-template-columns:1fr 360px; gap:1.5rem; align-items:start;">

    {{-- Carte principale --}}
    <div>
        <div class="cr-card">
            <div class="cr-card-header">
                <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem;">
                    <div>
                        <h1 style="font-size:1.5rem; font-weight:800; margin:0; color:white;">
                            {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
                        </h1>
                        <p style="margin:6px 0 0; opacity:0.85; font-size:0.9rem;">
                            🕐 {{ $trajet->horaire->format('l d F Y à H:i') }}
                        </p>
                    </div>
                    @if($scoreResult)
                        <div class="ia-score-circle {{ $scoreResult['score'] >= 70 ? 'ia-score-high' : ($scoreResult['score'] >= 40 ? 'ia-score-medium' : 'ia-score-low') }}">
                            {{ $scoreResult['score'] }}
                        </div>
                    @endif
                </div>
            </div>

            <div style="padding:1.5rem;">
                {{-- Infos clés --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">

                    <div style="background:#f8fafc; border-radius:12px; padding:1rem;">
                        <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#94a3b8; margin-bottom:6px;">Conducteur</div>
                        <div style="font-weight:700; color:#0f172a; font-size:0.95rem;">{{ $trajet->conducteur->name }}</div>
                        <div style="font-size:0.8rem; color:#64748b;">{{ $trajet->conducteur->entreprise->nom ?? '' }}</div>
                        <div style="font-size:0.8rem; color:#64748b;">📍 {{ $trajet->conducteur->ville_residence }}</div>
                    </div>

                    <div style="background:#f8fafc; border-radius:12px; padding:1rem;">
                        <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#94a3b8; margin-bottom:6px;">Places disponibles</div>
                        <div class="{{ $restantes === 0 ? 'places-full' : ($restantes === 1 ? 'places-low' : 'places-ok') }}" style="font-size:1.5rem; font-weight:800;">
                            {{ $restantes }} / {{ $trajet->places_disponibles }}
                        </div>
                        <div style="font-size:0.8rem; color:#64748b;">
                            @if($restantes === 0) Trajet complet
                            @elseif($restantes === 1) Dernière place !
                            @else {{ $restantes }} places restantes
                            @endif
                        </div>
                    </div>

                </div>

                @if($trajet->jours_recurrence)
                <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:10px; padding:1rem; margin-bottom:1rem;">
                    <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; color:#0369a1; margin-bottom:4px;">📅 Jours de récurrence</div>
                    <div style="font-size:0.9rem; color:#0c4a6e; font-weight:500;">{{ $trajet->jours_recurrence }}</div>
                </div>
                @endif

                {{-- Réservations passagers (visibles pour le conducteur du trajet) --}}
                @if($estMien && $trajet->reservations->count() > 0)
                <div style="margin-top:1.5rem;">
                    <h3 style="font-size:0.9rem; font-weight:700; color:#374151; margin-bottom:0.75rem; display:flex; align-items:center; gap:6px;">
                        👥 Demandes de réservation sur ce trajet ({{ $trajet->reservations->count() }})
                    </h3>
                    <div style="display:flex; flex-direction:column; gap:0.5rem;">
                        @foreach($trajet->reservations as $res)
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem 1rem; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">
                            <div>
                                <span style="font-weight:600; font-size:0.875rem;">{{ $res->passager->name }}</span>
                                <span style="color:#64748b; font-size:0.8rem; margin-left:8px;">{{ $res->passager->ville_residence }}</span>
                            </div>
                            <span class="badge-{{ $res->statut }}">
                                {{ ['en_attente'=>'En attente','confirmee'=>'Confirmée','refusee'=>'Refusée','annulee'=>'Annulée'][$res->statut] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- Score IA détaillé --}}
        @if($scoreResult)
        <div class="ia-score-card" style="margin-top:1.25rem;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:1rem;">
                <div class="ia-score-circle {{ $scoreResult['score'] >= 70 ? 'ia-score-high' : ($scoreResult['score'] >= 40 ? 'ia-score-medium' : 'ia-score-low') }}">
                    {{ $scoreResult['score'] }}
                </div>
                <div>
                    <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#0369a1;">🤖 Score de compatibilité IA</div>
                    <div style="font-size:0.9rem; font-weight:700; color:#0c4a6e;">
                        @if($scoreResult['score'] >= 85) Excellente compatibilité
                        @elseif($scoreResult['score'] >= 70) Bonne compatibilité
                        @elseif($scoreResult['score'] >= 50) Compatibilité moyenne
                        @else Compatibilité limitée
                        @endif
                    </div>
                </div>
            </div>
            <div style="background:white; border-radius:10px; padding:1rem; margin-bottom:0.875rem;">
                <div style="font-size:0.7rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.5rem;">Analyse détaillée</div>
                <pre style="font-size:0.82rem; color:#374151; line-height:1.65; white-space:pre-wrap; margin:0; font-family:inherit;">{{ $scoreResult['justification'] }}</pre>
            </div>
            @if(!empty($scoreResult['horaire_suggere']))
            <div style="background:white; border-radius:10px; padding:0.875rem;">
                <div style="font-size:0.7rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">⏰ Horaire suggéré</div>
                <div style="font-size:0.875rem; color:#0c4a6e; font-weight:500;">{{ $scoreResult['horaire_suggere'] }}</div>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Sidebar actions --}}
    <div style="display:flex; flex-direction:column; gap:1rem;">

        {{-- Actions sur le trajet d'un autre utilisateur --}}
        @if(!$estMien)
            @if(!$scoreResult)
            <div class="cr-card" style="padding:1.25rem;">
                <h3 style="font-size:0.875rem; font-weight:700; color:#374151; margin:0 0 0.75rem;">🤖 Score de compatibilité IA</h3>
                <p style="font-size:0.8rem; color:#64748b; margin:0 0 1rem; line-height:1.5;">
                    Obtenez un score personnalisé expliquant pourquoi ce trajet vous correspond.
                </p>
                <form method="POST" action="{{ route('trajets.score', $trajet) }}">
                    @csrf
                    <button type="submit" class="btn-cr-primary" style="width:100%; justify-content:center;">
                        🤖 Calculer mon score
                    </button>
                </form>
            </div>
            @endif

            @if($dejaReserve)
            <div class="cr-card" style="padding:1.25rem; background:#f0fdf4; border:1.5px solid #86efac;">
                <div style="font-size:0.875rem; font-weight:600; color:#166534; text-align:center;">
                    ✅ Vous avez déjà réservé ce trajet
                </div>
                <a href="{{ route('reservations.index') }}" class="btn-cr-secondary" style="width:100%; justify-content:center; margin-top:0.75rem;">
                    Voir mes réservations
                </a>
            </div>
            @elseif($restantes > 0 && auth()->user()->role !== 'conducteur')
            <div class="cr-card" style="padding:1.25rem;">
                <h3 style="font-size:0.875rem; font-weight:700; color:#374151; margin:0 0 0.75rem;">🪑 Réserver ce trajet</h3>
                <p style="font-size:0.8rem; color:#64748b; margin:0 0 1rem;">{{ $restantes }} place{{ $restantes > 1 ? 's disponibles' : ' disponible' }}</p>
                <a href="{{ route('reservations.create', ['trajet_id' => $trajet->id]) }}" class="btn-cr-success" style="width:100%; justify-content:center;">
                    ✚ Réserver maintenant
                </a>
            </div>
            @elseif($restantes === 0)
            <div class="cr-card" style="padding:1.25rem; background:#fff1f2; border:1.5px solid #fca5a5;">
                <div style="font-size:0.875rem; font-weight:600; color:#7f1d1d; text-align:center;">
                    ✗ Trajet complet — aucune place disponible
                </div>
            </div>
            @endif
        @endif

        {{-- Actions Conducteur (sur son propre trajet) --}}
        @if($estMien && $estConducteur)
        <div class="cr-card" style="padding:1.25rem;">
            <h3 style="font-size:0.875rem; font-weight:700; color:#374151; margin:0 0 0.75rem;">🚘 Gérer votre trajet</h3>
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <a href="{{ route('trajets.edit', $trajet) }}" class="btn-cr-warning" style="justify-content:center;">✏️ Modifier</a>
                <form action="{{ route('trajets.destroy', $trajet) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-cr-danger" style="width:100%; justify-content:center;"
                        onclick="return confirm('Supprimer ce trajet ?')">🗑 Supprimer</button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection