<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="CoRide — Le covoiturage intelligent en entreprise.">

        <title>{{ config('app.name', 'CoRide') }} — @yield('title', 'Covoiturage en entreprise')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            /* ═══════════════════════════════════════
               DESIGN TOKENS — LIGHT & DARK
            ═══════════════════════════════════════ */
            :root, [data-theme="light"] {
                --bg-base:      #f8fafc;
                --bg-surface:   #ffffff;
                --bg-subtle:    #f1f5f9;
                --bg-muted:     #e2e8f0;

                --text-primary:  #0d1117;
                --text-secondary:#4b5563;
                --text-muted:    #94a3b8;
                --text-inverse:  #ffffff;

                --border:        #e2e8f0;
                --border-focus:  #e11d48;

                --red:           #e11d48;
                --red-dark:      #be123c;
                --red-light:     #fda4af;
                --red-bg:        #fff1f2;
                --red-bg-hover:  #ffe4e6;

                --green:         #059669;
                --amber:         #d97706;
                --sky:           #0284c7;

                --shadow-sm:  0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
                --shadow-md:  0 4px 16px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);
                --shadow-card: 0 2px 8px rgba(0,0,0,0.06);
                --shadow-hover: 0 8px 24px rgba(0,0,0,0.09);

                --nav-blur:   rgba(255,255,255,0.9);
            }

            [data-theme="dark"] {
                --bg-base:      #0d1117;
                --bg-surface:   #161b22;
                --bg-subtle:    #1c2128;
                --bg-muted:     #21262d;

                --text-primary:  #e6edf3;
                --text-secondary:#8b949e;
                --text-muted:    #6e7681;
                --text-inverse:  #0d1117;

                --border:        #30363d;
                --border-focus:  #e11d48;

                --red:           #f43f5e;
                --red-dark:      #e11d48;
                --red-light:     #fb7185;
                --red-bg:        rgba(225,29,72,0.15);
                --red-bg-hover:  rgba(225,29,72,0.22);

                --green:         #3fb950;
                --amber:         #e3b341;
                --sky:           #58a6ff;

                --shadow-sm:  0 1px 3px rgba(0,0,0,0.4);
                --shadow-md:  0 4px 16px rgba(0,0,0,0.5);
                --shadow-card: 0 2px 8px rgba(0,0,0,0.4);
                --shadow-hover: 0 8px 24px rgba(0,0,0,0.6);

                --nav-blur:   rgba(13,17,23,0.9);
            }

            /* ═══════════════════════════════════════
               DARK MODE — OVERRIDES GLOBAUX
               Force tout le texte inline codé en dur
               à être visible sur fond sombre
            ═══════════════════════════════════════ */
            [data-theme="dark"] body,
            [data-theme="dark"] p,
            [data-theme="dark"] span:not(.badge-en_attente):not(.badge-confirmee):not(.badge-refusee):not(.badge-annulee),
            [data-theme="dark"] div,
            [data-theme="dark"] h1,
            [data-theme="dark"] h2,
            [data-theme="dark"] h3,
            [data-theme="dark"] h4,
            [data-theme="dark"] td,
            [data-theme="dark"] th,
            [data-theme="dark"] label,
            [data-theme="dark"] li,
            [data-theme="dark"] pre {
                color: inherit;
            }

            /* Conteneurs principaux en dark */
            [data-theme="dark"] .cr-card  { background: var(--bg-surface) !important; border-color: var(--border) !important; color: var(--text-primary) !important; }
            [data-theme="dark"] .cr-main  { color: var(--text-primary); }

            /* Tout texte sombre dans les conteneurs de page */
            [data-theme="dark"] .cr-main h1,
            [data-theme="dark"] .cr-main h2,
            [data-theme="dark"] .cr-main h3 { color: var(--text-primary) !important; }

            [data-theme="dark"] .cr-main p,
            [data-theme="dark"] .cr-main span,
            [data-theme="dark"] .cr-main div { color: inherit; }

            /* Override spécifique des couleurs inline les plus fréquentes */
            [data-theme="dark"] [style*="color:#0f172a"],
            [data-theme="dark"] [style*="color:#0d1117"],
            [data-theme="dark"] [style*="color:#1e293b"],
            [data-theme="dark"] [style*="color:#374151"],
            [data-theme="dark"] [style*="color:#111827"],
            [data-theme="dark"] [style*="color:#4b5563"] {
                color: var(--text-primary) !important;
            }

            [data-theme="dark"] [style*="color:#64748b"],
            [data-theme="dark"] [style*="color:#6b7280"],
            [data-theme="dark"] [style*="color:#9ca3af"],
            [data-theme="dark"] [style*="color:#94a3b8"] {
                color: var(--text-secondary) !important;
            }

            /* Fonds de page / cartes en dark */
            [data-theme="dark"] [style*="background:#f8fafc"],
            [data-theme="dark"] [style*="background:#f1f5f9"],
            [data-theme="dark"] [style*="background:#f0f9ff"],
            [data-theme="dark"] [style*="background:#f0fdf4"],
            [data-theme="dark"] [style*="background:#fef3c7"],
            [data-theme="dark"] [style*="background:#fff1f2"],
            [data-theme="dark"] [style*="background:#ffe4e6"],
            [data-theme="dark"] [style*="background:white"],
            [data-theme="dark"] [style*="background:#ffffff"],
            [data-theme="dark"] [style*="background: white"],
            [data-theme="dark"] [style*="background: #ffffff"] {
                background: var(--bg-subtle) !important;
            }

            /* Bordures en dark */
            [data-theme="dark"] [style*="border-color:#e2e8f0"],
            [data-theme="dark"] [style*="border:1px solid #e2e8f0"],
            [data-theme="dark"] [style*="border-bottom:1px solid #f1f5f9"],
            [data-theme="dark"] [style*="border-top:1px solid #e2e8f0"] {
                border-color: var(--border) !important;
            }

            /* Inputs en dark */
            [data-theme="dark"] input,
            [data-theme="dark"] select,
            [data-theme="dark"] textarea {
                background: var(--bg-subtle) !important;
                color: var(--text-primary) !important;
                border-color: var(--border) !important;
            }

            /* Stats numbers hardcodés */
            [data-theme="dark"] [style*="color:#e11d48"] { color: var(--red) !important; }
            [data-theme="dark"] [style*="color:#059669"] { color: var(--green) !important; }
            [data-theme="dark"] [style*="color:#d97706"] { color: var(--amber) !important; }



            /* ═══════════════════════════════════════
               BASE
            ═══════════════════════════════════════ */
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'DM Sans', sans-serif;
                background: var(--bg-base);
                color: var(--text-primary);
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
                transition: background 0.3s ease, color 0.3s ease;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Sora', sans-serif;
                font-weight: 700;
                line-height: 1.2;
                color: var(--text-primary);
                transition: color 0.3s ease;
            }

            /* Propagation couleur vers tous les descendants */
            .cr-main {
                padding: 2.5rem 1.5rem;
                max-width: 1280px;
                margin: 0 auto;
                color: var(--text-primary);
            }


            /* ═══════════════════════════════════════
               NAVBAR
            ═══════════════════════════════════════ */
            .cr-navbar {
                background: var(--nav-blur);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-bottom: 1px solid var(--border);
                position: sticky; top: 0; z-index: 1000;
                box-shadow: var(--shadow-sm);
                transition: background 0.3s ease, border-color 0.3s ease;
            }
            .cr-navbar-inner {
                max-width: 1280px; margin: 0 auto;
                padding: 0 2rem;
                display: flex; align-items: center; justify-content: space-between; height: 64px;
            }

            .cr-brand {
                font-family: 'Sora', sans-serif;
                font-size: 1.45rem; font-weight: 800; letter-spacing: -0.6px;
                text-decoration: none; color: var(--text-primary);
                display: flex; align-items: center; gap: 2px;
            }
            .cr-brand .brand-co  { color: var(--text-primary); }
            .cr-brand .brand-ride { color: var(--red); }

            .cr-nav-links { display: flex; align-items: center; gap: 2px; }
            .cr-nav-link {
                font-family: 'DM Sans', sans-serif;
                color: var(--text-secondary); font-size: 0.875rem; font-weight: 500;
                padding: 0.45rem 0.9rem; border-radius: 8px;
                transition: all 0.15s ease; text-decoration: none;
                display: flex; align-items: center; gap: 5px;
                white-space: nowrap; letter-spacing: 0.1px;
            }
            .cr-nav-link:hover { color: var(--text-primary); background: var(--bg-subtle); }
            .cr-nav-link.active { color: var(--red); background: var(--red-bg); font-weight: 600; }

            /* ═══════════════════════════════════════
               DARK MODE TOGGLE
            ═══════════════════════════════════════ */
            .theme-toggle {
                width: 38px; height: 38px;
                border-radius: 10px;
                border: 1.5px solid var(--border);
                background: var(--bg-subtle);
                color: var(--text-secondary);
                cursor: pointer;
                display: flex; align-items: center; justify-content: center;
                font-size: 1rem;
                transition: all 0.2s ease;
                flex-shrink: 0;
            }
            .theme-toggle:hover { border-color: var(--red); color: var(--red); background: var(--red-bg); }

            /* ═══════════════════════════════════════
               BUTTONS
            ═══════════════════════════════════════ */
            .btn-cr-primary {
                background: var(--red);
                color: #fff; border: none;
                padding: 0.575rem 1.35rem;
                border-radius: 9px; font-weight: 600; font-size: 0.875rem;
                cursor: pointer; transition: all 0.2s ease;
                text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
                box-shadow: 0 2px 8px rgba(225,29,72,0.3);
                white-space: nowrap; font-family: 'DM Sans', sans-serif;
                letter-spacing: 0.1px;
            }
            .btn-cr-primary:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(225,29,72,0.4); color: #fff; }
            .btn-cr-primary:active { transform: translateY(0); }

            .btn-cr-secondary {
                background: var(--bg-surface); color: var(--text-primary);
                border: 1.5px solid var(--border);
                padding: 0.55rem 1.3rem;
                border-radius: 9px; font-weight: 500; font-size: 0.875rem;
                cursor: pointer; transition: all 0.2s ease;
                text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
                white-space: nowrap; font-family: 'DM Sans', sans-serif;
            }
            .btn-cr-secondary:hover { border-color: var(--red); color: var(--red); background: var(--red-bg); }

            .btn-cr-success {
                background: var(--green); color: #fff; border: none;
                padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem;
                cursor: pointer; transition: all 0.2s; text-decoration: none;
                display: inline-flex; align-items: center; gap: 5px;
                font-family: 'DM Sans', sans-serif;
            }
            .btn-cr-success:hover { filter: brightness(1.1); transform: translateY(-1px); color: #fff; }

            .btn-cr-warning {
                background: var(--amber); color: #fff; border: none;
                padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem;
                cursor: pointer; transition: all 0.2s; text-decoration: none;
                display: inline-flex; align-items: center; gap: 5px;
                font-family: 'DM Sans', sans-serif;
            }
            .btn-cr-warning:hover { filter: brightness(1.1); transform: translateY(-1px); color: #fff; }

            .btn-cr-danger {
                background: var(--red); color: #fff; border: none;
                padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem;
                cursor: pointer; transition: all 0.2s; text-decoration: none;
                display: inline-flex; align-items: center; gap: 5px;
                font-family: 'DM Sans', sans-serif;
            }
            .btn-cr-danger:hover { background: var(--red-dark); transform: translateY(-1px); color: #fff; }

            .btn-cr-info {
                background: var(--sky); color: #fff; border: none;
                padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem;
                cursor: pointer; transition: all 0.2s; text-decoration: none;
                display: inline-flex; align-items: center; gap: 5px;
                font-family: 'DM Sans', sans-serif;
            }
            .btn-cr-info:hover { filter: brightness(1.1); transform: translateY(-1px); color: #fff; }

            /* ═══════════════════════════════════════
               CARDS
            ═══════════════════════════════════════ */
            .cr-card {
                background: var(--bg-surface);
                border-radius: 14px;
                border: 1px solid var(--border);
                box-shadow: var(--shadow-card);
                transition: box-shadow 0.2s ease, border-color 0.2s ease, transform 0.2s ease, background 0.3s ease;
                overflow: hidden;
            }
            .cr-card:hover { box-shadow: var(--shadow-hover); border-color: var(--red-light); transform: translateY(-2px); }
            .cr-card-header {
                background: linear-gradient(135deg, var(--red), var(--red-dark));
                padding: 1.25rem 1.5rem; color: #fff;
            }

            /* ═══════════════════════════════════════
               STATUS BADGES
            ═══════════════════════════════════════ */
            .badge-en_attente { background: rgba(217,119,6,0.12); color: var(--amber); border: 1px solid rgba(217,119,6,0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; font-family: 'DM Sans',sans-serif; }
            .badge-confirmee   { background: rgba(5,150,105,0.12); color: var(--green); border: 1px solid rgba(5,150,105,0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; font-family: 'DM Sans',sans-serif; }
            .badge-refusee     { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-light); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; font-family: 'DM Sans',sans-serif; }
            .badge-annulee     { background: var(--bg-subtle); color: var(--text-secondary); border: 1px solid var(--border); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; font-family: 'DM Sans',sans-serif; }

            /* ═══════════════════════════════════════
               IA SCORE
            ═══════════════════════════════════════ */
            .ia-score-card {
                background: var(--red-bg);
                border: 1.5px solid var(--red-light);
                border-radius: 14px; padding: 1.25rem;
                transition: background 0.3s ease;
            }
            .ia-score-circle {
                width: 68px; height: 68px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.3rem; font-weight: 800; flex-shrink: 0;
                font-family: 'Sora', sans-serif;
            }
            .ia-score-high   { background: rgba(5,150,105,0.15); color: var(--green); border: 2px solid rgba(5,150,105,0.4); }
            .ia-score-medium { background: rgba(217,119,6,0.15); color: var(--amber); border: 2px solid rgba(217,119,6,0.4); }
            .ia-score-low    { background: var(--red-bg); color: var(--red); border: 2px solid var(--red-light); }

            /* ═══════════════════════════════════════
               ALERTS
            ═══════════════════════════════════════ */
            .cr-alert-success { background: rgba(5,150,105,0.1); border-left: 4px solid var(--green); color: var(--green); padding: 0.875rem 1.25rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; font-weight: 500; }
            .cr-alert-error   { background: var(--red-bg); border-left: 4px solid var(--red); color: var(--red); padding: 0.875rem 1.25rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; font-weight: 500; }
            .cr-alert-info    { background: rgba(2,132,199,0.1); border-left: 4px solid var(--sky); color: var(--sky); padding: 0.875rem 1.25rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; font-weight: 500; }

            /* ═══════════════════════════════════════
               FORMS
            ═══════════════════════════════════════ */
            .cr-label {
                font-size: 0.82rem; font-weight: 600; letter-spacing: 0.3px;
                color: var(--text-secondary); margin-bottom: 6px; display: block;
                font-family: 'DM Sans', sans-serif; text-transform: uppercase;
            }
            .cr-input {
                width: 100%; padding: 0.7rem 1rem;
                border: 1.5px solid var(--border);
                border-radius: 9px; font-size: 0.9rem;
                transition: all 0.2s;
                background: var(--bg-surface); color: var(--text-primary);
                font-family: 'DM Sans', sans-serif;
                outline: none;
            }
            .cr-input:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(225,29,72,0.12); }
            select.cr-input option { background: var(--bg-surface); color: var(--text-primary); }

            /* ═══════════════════════════════════════
               TABLE
            ═══════════════════════════════════════ */
            .cr-table { width: 100%; border-collapse: collapse; }
            .cr-table th {
                background: var(--bg-subtle); color: var(--text-muted); font-size: 0.72rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.7px;
                padding: 0.875rem 1rem; border-bottom: 2px solid var(--border); text-align: left;
                font-family: 'DM Sans', sans-serif;
            }
            .cr-table td { padding: 1rem; border-bottom: 1px solid var(--border); font-size: 0.875rem; color: var(--text-primary); }
            .cr-table tr:hover td { background: var(--red-bg); }

            /* ═══════════════════════════════════════
               MISC
            ═══════════════════════════════════════ */
            .places-full { color: var(--red); font-weight: 700; }
            .places-low  { color: var(--amber); font-weight: 600; }
            .places-ok   { color: var(--green); font-weight: 600; }

            .cr-avatar {
                width: 36px; height: 36px; border-radius: 50%;
                background: linear-gradient(135deg, var(--red), var(--red-dark));
                display: flex; align-items: center; justify-content: center;
                color: #fff; font-weight: 700; font-size: 0.85rem;
                box-shadow: 0 2px 8px rgba(225,29,72,0.3); flex-shrink: 0;
                font-family: 'Sora', sans-serif;
            }

            .cr-main { padding: 2.5rem 1.5rem; max-width: 1280px; margin: 0 auto; }
            @media (min-width: 768px) { .cr-main { padding: 2.5rem 2rem; } }

            /* ═══════════════════════════════════════
               TRANSITION DOUCE AU CHANGEMENT DE THEME
            ═══════════════════════════════════════ */
            .cr-card, .cr-navbar, .cr-input, body, .cr-nav-link, .btn-cr-secondary { transition-duration: 0.25s; }
        </style>
    </head>

    <body>
        @php $userRole = auth()->user()->role ?? null; @endphp

        {{-- NAVBAR --}}
        <nav class="cr-navbar">
            <div class="cr-navbar-inner">

                <a href="{{ route('dashboard') }}" class="cr-brand">
                    <span class="brand-co">Co</span><span class="brand-ride">Ride</span>
                </a>

                <div class="cr-nav-links">
                    <a href="{{ route('trajets.index') }}" class="cr-nav-link {{ request()->routeIs('trajets.index') ? 'active' : '' }}">
                        Trajets
                    </a>
                    @if(in_array($userRole, ['conducteur', 'les_deux']))
                        <a href="{{ route('trajets.mes-trajets') }}" class="cr-nav-link {{ request()->routeIs('trajets.mes-trajets') ? 'active' : '' }}">
                            Mes Trajets
                        </a>
                    @endif
                    <a href="{{ route('reservations.index') }}" class="cr-nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                        {{ $userRole === 'conducteur' ? 'Demandes' : ($userRole === 'passager' ? 'Réservations' : 'Réservations') }}
                    </a>
                    <a href="{{ route('dashboard') }}" class="cr-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    @if(in_array($userRole, ['conducteur', 'les_deux']))
                        <a href="{{ route('trajets.create') }}" class="btn-cr-primary" style="font-size:0.8rem; padding:0.4rem 1rem;">
                            ＋ Publier
                        </a>
                    @endif

                    {{-- Dark Mode Toggle --}}
                    <button class="theme-toggle" id="themeToggle" title="Basculer le mode sombre" type="button">
                        <span id="themeIcon">🌙</span>
                    </button>

                    <a href="{{ route('profile.edit') }}" style="text-decoration:none;" title="{{ auth()->user()->name }}">
                        <div class="cr-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" id="logoutBtn"
                            style="background:transparent; border:1.5px solid var(--border); color:var(--text-secondary);
                                   padding:6px 14px; border-radius:8px; font-size:0.8rem; cursor:pointer;
                                   transition:all 0.2s; font-family:'DM Sans',sans-serif; letter-spacing:0.1px;"
                            onmouseover="this.style.borderColor='var(--red)';this.style.color='var(--red)'"
                            onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- CONTENT --}}
        <main class="cr-main">
            @if(session('success'))
                <div class="cr-alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="cr-alert-error">⚠️ {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="cr-alert-error">
                    <strong>Erreurs de validation :</strong>
                    <ul style="margin:0.5rem 0 0 1rem; padding:0;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>

        {{-- DARK MODE SCRIPT --}}
        <script>
            (function () {
                const html       = document.documentElement;
                const btn        = document.getElementById('themeToggle');
                const icon       = document.getElementById('themeIcon');
                const STORAGE_KEY = 'cr-theme';

                // Initialisation : préférence sauvegardée ou préférence système
                const saved = localStorage.getItem(STORAGE_KEY);
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const initial = saved || (prefersDark ? 'dark' : 'light');
                applyTheme(initial);

                btn.addEventListener('click', function () {
                    const current = html.getAttribute('data-theme');
                    const next    = current === 'dark' ? 'light' : 'dark';
                    applyTheme(next);
                    localStorage.setItem(STORAGE_KEY, next);
                });

                function applyTheme(theme) {
                    html.setAttribute('data-theme', theme);
                    icon.textContent = theme === 'dark' ? '☀️' : '🌙';
                }
            })();
        </script>
    </body>
</html>