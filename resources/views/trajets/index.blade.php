@extends('layouts.app')
@section('title', 'Tous les trajets')

@section('content')

@php
    $userRole      = auth()->user()->role;
    $estConducteur = in_array($userRole, ['conducteur', 'les_deux']);
@endphp

{{-- En-tête --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
    <div>
        <h1 style="font-size:1.6rem; font-weight:800; color:#0f172a; margin:0;">🗺️ Trajets disponibles</h1>
        <p style="color:#64748b; margin:0.25rem 0 0; font-size:0.875rem;">
            {{ $trajets->count() }} trajet{{ $trajets->count() > 1 ? 's' : '' }} trouvé{{ $trajets->count() > 1 ? 's' : '' }}
            @if(count($scoresIA) > 0)
                · <span style="color:#6366f1; font-weight:600;">🤖 Score IA activé</span>
            @endif
        </p>
    </div>
    @if($estConducteur)
        <a href="{{ route('trajets.create') }}" class="btn-cr-primary">＋ Publier un trajet</a>
    @endif
</div>

{{-- Barre de recherche --}}
<div class="cr-card" style="padding:1.25rem; margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('trajets.index') }}" style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:flex-end;">
        <div style="flex:1; min-width:140px;">
            <label class="cr-label">Ville de départ</label>
            <input type="text" name="ville_depart" class="cr-input" placeholder="ex: Lyon" value="{{ request('ville_depart') }}">
        </div>
        <div style="flex:1; min-width:140px;">
            <label class="cr-label">Ville d'arrivée</label>
            <input type="text" name="ville_arrivee" class="cr-input" placeholder="ex: Villeurbanne" value="{{ request('ville_arrivee') }}">
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
            <label class="cr-label">&nbsp;</label>
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.875rem; color:#374151;">
                <input type="checkbox" name="places_dispo" value="1" {{ request('places_dispo') ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#6366f1;">
                Places disponibles uniquement
            </label>
        </div>

        <div style="display:flex; flex-direction:column; gap:6px;">
            <label class="cr-label">&nbsp;</label>
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.875rem; color:#374151;">
                <input type="checkbox" name="avec_score" value="1" {{ request('avec_score') ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#6366f1;">
                🤖 Score IA de compatibilité
            </label>
        </div>

        <button type="submit" class="btn-cr-primary">🔍 Rechercher</button>
        @if(request()->anyFilled(['ville_depart','ville_arrivee','places_dispo','avec_score']))
            <a href="{{ route('trajets.index') }}" class="btn-cr-secondary">✕ Réinitialiser</a>
        @endif
    </form>
</div>

{{-- Info IA --}}
@if(count($scoresIA) > 0)
<div class="cr-alert-info" style="margin-bottom:1.5rem; display:flex; align-items:flex-start; gap:10px;">
    <span style="font-size:1.2rem;">🤖</span>
    <div>
        <strong>Score IA activé</strong> — Les trajets sont triés par pertinence en fonction de votre ville ({{ auth()->user()->ville_residence }}) et de votre entreprise ({{ auth()->user()->entreprise->nom ?? '' }}).
    </div>
</div>
@endif

{{-- Liste des trajets --}}
@if($trajets->count() > 0)

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(340px,1fr)); gap:1.25rem;">

        @foreach($trajets as $trajet)
        @php
            $score     = $scoresIA[$trajet->id] ?? null;
            $restantes = $trajet->placesRestantes();
            $estMien   = $trajet->conducteur_id === auth()->id();
        @endphp

        <div class="cr-card" style="display:flex; flex-direction:column;">

            {{-- Header carte --}}
            <div style="background:linear-gradient(135deg,#6366f1,#8b5cf6); padding:1.1rem 1.25rem; color:white;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <div style="font-size:1.05rem; font-weight:700;">
                            {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
                        </div>
                        <div style="font-size:0.8rem; opacity:0.85; margin-top:4px;">
                            🕐 {{ $trajet->horaire->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                    @if($score)
                        <div class="ia-score-circle {{ $score['score'] >= 70 ? 'ia-score-high' : ($score['score'] >= 40 ? 'ia-score-medium' : 'ia-score-low') }}" style="width:52px; height:52px; font-size:1.1rem;">
                            {{ $score['score'] }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Contenu carte --}}
            <div style="padding:1.1rem 1.25rem; flex:1; display:flex; flex-direction:column; gap:0.625rem;">

                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <span style="font-size:0.8rem; color:#64748b;">👤 Conducteur</span>
                    <span style="font-size:0.85rem; font-weight:600; color:#374151;">{{ $trajet->conducteur->name }}</span>
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <span style="font-size:0.8rem; color:#64748b;">🏢 Entreprise</span>
                    <span style="font-size:0.8rem; color:#374151;">{{ $trajet->conducteur->entreprise->nom ?? '—' }}</span>
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <span style="font-size:0.8rem; color:#64748b;">🪑 Places</span>
                    <span class="{{ $restantes === 0 ? 'places-full' : ($restantes === 1 ? 'places-low' : 'places-ok') }}" style="font-size:0.85rem;">
                        @if($restantes === 0)
                            ✗ Complet
                        @elseif($restantes === 1)
                            ⚠ 1 place restante
                        @else
                            ✓ {{ $restantes }} / {{ $trajet->places_disponibles }} places
                        @endif
                    </span>
                </div>

                @if($trajet->jours_recurrence)
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <span style="font-size:0.8rem; color:#64748b;">📅 Récurrence</span>
                    <span style="font-size:0.75rem; color:#374151; text-align:right; max-width:55%;">{{ $trajet->jours_recurrence }}</span>
                </div>
                @endif

                {{-- Score IA résumé --}}
                @if($score)
                <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:0.625rem; margin-top:0.25rem;">
                    <div style="font-size:0.7rem; font-weight:700; color:#0369a1; text-transform:uppercase; letter-spacing:0.3px; margin-bottom:4px;">🤖 Compatibilité IA</div>
                    <div style="font-size:0.75rem; color:#0c4a6e; line-height:1.4;">{{ Str::limit($score['justification'], 100) }}</div>
                </div>
                @endif

                @if($estMien)
                <div style="background:#f0fdf4; border:1px solid #86efac; border-radius:8px; padding:6px 10px; font-size:0.75rem; color:#166534; font-weight:600; text-align:center;">
                    🚗 C'est votre trajet
                </div>
                @endif

            </div>

            {{-- Actions --}}
            <div style="padding:0.875rem 1.25rem; border-top:1px solid #f1f5f9; display:flex; gap:0.5rem; flex-wrap:wrap;">
                <a href="{{ route('trajets.show', $trajet) }}" class="btn-cr-info" style="flex:1; justify-content:center;">
                    👁 Détails
                </a>

                {{-- Bouton réserver : si pas mon trajet et rôle autorisé --}}
                @if(!$estMien && auth()->user()->role !== 'conducteur' && $restantes > 0)
                    <a href="{{ route('reservations.create', ['trajet_id' => $trajet->id]) }}" class="btn-cr-success" style="flex:1; justify-content:center;">
                        ✚ Réserver
                    </a>
                @endif

                {{-- Bouton modifier : si c'est mon trajet --}}
                @if($estMien && $estConducteur)
                    <a href="{{ route('trajets.edit', $trajet) }}" class="btn-cr-warning" style="flex:1; justify-content:center;">
                        ✏️ Modifier
                    </a>
                @endif
            </div>

        </div>
        @endforeach

    </div>

@else
    <div class="cr-card" style="padding:3rem; text-align:center;">
        <div style="font-size:3rem; margin-bottom:1rem;">🚗</div>
        <h3 style="font-size:1.1rem; font-weight:700; color:#374151; margin-bottom:0.5rem;">Aucun trajet trouvé</h3>
        <p style="color:#64748b; font-size:0.9rem; margin-bottom:1.5rem;">Modifiez vos critères de recherche.</p>
        @if($estConducteur)
            <a href="{{ route('trajets.create') }}" class="btn-cr-primary">＋ Publier un trajet</a>
        @endif
    </div>
@endif

@endsection