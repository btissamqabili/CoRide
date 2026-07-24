<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoRide — Covoiturage Intelligent en Entreprise</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root, [data-theme="light"] {
            --bg-base:      #ffffff;
            --bg-surface:   #ffffff;
            --bg-subtle:    #f8fafc;
            --bg-section:   #f8fafc;
            --text-primary: #0d1117;
            --text-secondary:#4b5563;
            --text-muted:   #94a3b8;
            --border:       #e2e8f0;
            --red:          #e11d48;
            --red-dark:     #be123c;
            --red-light:    #fda4af;
            --red-bg:       #fff1f2;
            --nav-bg:       rgba(255,255,255,0.92);
            --shadow-nav:   0 1px 3px rgba(0,0,0,0.07);
            --card-bg:      #ffffff;
            --card-border:  #e2e8f0;
        }
        [data-theme="dark"] {
            --bg-base:      #0d1117;
            --bg-surface:   #161b22;
            --bg-subtle:    #1c2128;
            --bg-section:   #161b22;
            --text-primary: #e6edf3;
            --text-secondary:#8b949e;
            --text-muted:   #484f58;
            --border:       #30363d;
            --red:          #f43f5e;
            --red-dark:     #e11d48;
            --red-light:    #fb7185;
            --red-bg:       rgba(225,29,72,0.12);
            --nav-bg:       rgba(13,17,23,0.9);
            --shadow-nav:   0 1px 3px rgba(0,0,0,0.4);
            --card-bg:      #161b22;
            --card-border:  #30363d;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            transition: background 0.3s ease, color 0.3s ease;
        }
        h1, h2, h3 { font-family: 'Sora', sans-serif; line-height: 1.15; }

        /* ─── NAV ─── */
        .landing-nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem; height: 68px;
            border-bottom: 1px solid var(--border);
            background: var(--nav-bg);
            backdrop-filter: blur(20px);
            position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow-nav);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .landing-brand {
            font-family: 'Sora', sans-serif;
            font-size: 1.55rem; font-weight: 800; letter-spacing: -0.5px;
            text-decoration: none; color: var(--text-primary);
        }
        .landing-brand span { color: var(--red); }

        .theme-toggle {
            width: 36px; height: 36px; border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--bg-subtle);
            color: var(--text-secondary);
            cursor: pointer; font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .theme-toggle:hover { border-color: var(--red); color: var(--red); }

        /* ─── HERO ─── */
        .hero-section {
            min-height: calc(100vh - 68px);
            display: flex; align-items: center;
            padding: 5rem 2.5rem;
            background:
                radial-gradient(ellipse 1000px 600px at 110% 50%, rgba(225,29,72,0.07), transparent),
                var(--bg-base);
        }
        .hero-inner {
            max-width: 1280px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 5rem; align-items: center; width: 100%;
        }
        @media (max-width: 900px) { .hero-inner { grid-template-columns: 1fr; } .hero-visual { display: none; } }

        .badge-pill {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--red-bg); color: var(--red);
            border: 1px solid var(--red-light);
            padding: 5px 16px; border-radius: 100px;
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.3px;
            margin-bottom: 1.5rem; font-family: 'DM Sans', sans-serif;
        }
        .hero-title {
            font-size: 3.5rem; font-weight: 800;
            letter-spacing: -1.5px; color: var(--text-primary);
            margin-bottom: 1.25rem;
        }
        .hero-title .hl { color: var(--red); }
        .hero-desc {
            font-size: 1.05rem; color: var(--text-secondary);
            line-height: 1.75; margin-bottom: 2.25rem; max-width: 500px;
        }
        .hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; }

        .btn-hero-primary {
            background: var(--red); color: #fff;
            padding: 0.875rem 1.875rem; border-radius: 10px;
            font-weight: 700; font-size: 0.975rem;
            text-decoration: none; transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 16px rgba(225,29,72,0.3);
            font-family: 'DM Sans', sans-serif;
        }
        .btn-hero-primary:hover { background: var(--red-dark); transform: translateY(-2px); box-shadow: 0 8px 28px rgba(225,29,72,0.4); color: #fff; }

        .btn-hero-outline {
            background: transparent; color: var(--text-primary);
            border: 1.5px solid var(--border);
            padding: 0.875rem 1.875rem; border-radius: 10px;
            font-weight: 600; font-size: 0.975rem;
            text-decoration: none; transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-hero-outline:hover { border-color: var(--red); color: var(--red); background: var(--red-bg); }

        /* ─── CARD MOCK ─── */
        .hero-visual { position: relative; }
        .hero-card-mock {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px; padding: 1.75rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .mock-header {
            background: linear-gradient(135deg, var(--red), var(--red-dark));
            color: white; border-radius: 12px;
            padding: 1.25rem 1.5rem; margin-bottom: 1.25rem;
        }
        .mock-route { font-family: 'Sora', sans-serif; font-size: 1.1rem; font-weight: 800; margin-bottom: 4px; }
        .mock-time { font-size: 0.82rem; opacity: 0.85; font-family: 'DM Sans', sans-serif; }
        .mock-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.75rem 0; border-bottom: 1px solid var(--border);
            font-size: 0.875rem; font-family: 'DM Sans', sans-serif;
        }
        .mock-row:last-child { border-bottom: none; }
        .mock-label { color: var(--text-muted); font-weight: 500; }
        .mock-val { color: var(--text-primary); font-weight: 600; }
        .ia-badge {
            background: var(--red-bg); color: var(--red);
            border: 1px solid var(--red-light);
            border-radius: 10px; padding: 0.875rem 1rem;
            margin-top: 1rem; font-size: 0.8rem; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            display: flex; align-items: flex-start; gap: 10px;
        }
        .ia-score-pill {
            background: rgba(5,150,105,0.15); color: #059669;
            border: 2px solid rgba(5,150,105,0.35);
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1rem;
            flex-shrink: 0;
        }

        /* ─── FEATURES ─── */
        .features-section {
            background: var(--bg-section);
            padding: 5rem 2.5rem;
            border-top: 1px solid var(--border);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .features-inner { max-width: 1280px; margin: 0 auto; }
        .section-tag {
            display: inline-block; font-size: 0.72rem; font-weight: 800;
            letter-spacing: 1.5px; text-transform: uppercase; color: var(--red);
            margin-bottom: 0.75rem; font-family: 'DM Sans', sans-serif;
        }
        .section-title { font-size: 2.25rem; font-weight: 800; letter-spacing: -0.5px; color: var(--text-primary); margin-bottom: 0.75rem; }
        .section-desc { color: var(--text-secondary); font-size: 1rem; margin-bottom: 3rem; max-width: 520px; font-family: 'DM Sans', sans-serif; }

        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px,1fr)); gap: 1.5rem; }
        .feature-card {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 16px; padding: 2rem;
            transition: all 0.2s ease;
        }
        .feature-card:hover { border-color: var(--red-light); box-shadow: 0 8px 24px rgba(225,29,72,0.1); transform: translateY(-3px); }
        .feature-icon {
            width: 50px; height: 50px; border-radius: 14px;
            background: var(--red-bg); border: 1px solid var(--red-light);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 1.25rem;
        }
        .feature-title { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-primary); }
        .feature-desc  { font-size: 0.875rem; color: var(--text-secondary); line-height: 1.65; font-family: 'DM Sans', sans-serif; }

        /* ─── FOOTER ─── */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem 2.5rem;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 1rem;
            background: var(--bg-base);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .footer-brand { font-family: 'Sora', sans-serif; font-size: 1.2rem; font-weight: 800; color: var(--text-primary); }
        .footer-brand span { color: var(--red); }
        footer p { color: var(--text-muted); font-size: 0.8rem; font-family: 'DM Sans', sans-serif; }
    </style>
</head>
<body>

    <nav class="landing-nav">
        <a href="/" class="landing-brand">Co<span>Ride</span></a>
        <div style="display:flex; align-items:center; gap:0.75rem;">
            <button class="theme-toggle" id="themeToggle" type="button" title="Changer le thème">
                <span id="themeIcon">🌙</span>
            </button>
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-hero-primary" style="padding:0.55rem 1.35rem; font-size:0.875rem;">
                        Mon Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-hero-outline" style="padding:0.55rem 1.35rem; font-size:0.875rem;">
                        Connexion
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-hero-primary" style="padding:0.55rem 1.35rem; font-size:0.875rem;">
                            Créer un compte
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-inner">
            <div>
                <div class="badge-pill">✨ Score IA de Compatibilité Intelligente</div>
                <h1 class="hero-title">
                    Covoiturez<br><span class="hl">entre collègues</span>,<br>simplement.
                </h1>
                <p class="hero-desc">
                    CoRide connecte les salariés vivant dans des zones proches grâce à une analyse IA des trajets, des horaires et des récurrences.
                </p>
                <div class="hero-actions">
                    @auth
                        <a href="{{ route('trajets.index', ['avec_score' => 1]) }}" class="btn-hero-primary">🚀 Trouver un trajet</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-hero-primary">🚀 Rejoindre CoRide</a>
                        <a href="{{ route('login') }}" class="btn-hero-outline">Connexion</a>
                    @endauth
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-card-mock">
                    <div class="mock-header">
                        <div class="mock-route">Lyon → Villeurbanne</div>
                        <div class="mock-time">🕐 Lun, 05/08/2026 · 08h15</div>
                    </div>
                    <div class="mock-row">
                        <span class="mock-label">👤 Conducteur</span>
                        <span class="mock-val">François Morel</span>
                    </div>
                    <div class="mock-row">
                        <span class="mock-label">🏢 Entreprise</span>
                        <span class="mock-val">MobiliTech</span>
                    </div>
                    <div class="mock-row">
                        <span class="mock-label">🪑 Places</span>
                        <span class="mock-val" style="color:#059669;">✓ 3 disponibles</span>
                    </div>
                    <div class="mock-row">
                        <span class="mock-label">📅 Récurrence</span>
                        <span class="mock-val">Lun, Mar, Ven</span>
                    </div>
                    <div class="ia-badge">
                        <div class="ia-score-pill">92</div>
                        <div>
                            <strong>Score IA — Excellente compatibilité</strong><br>
                            <span style="opacity:0.8; font-weight:400;">Même zone, même entreprise, horaire idéal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="features-inner">
            <span class="section-tag">Pourquoi CoRide ?</span>
            <h2 class="section-title">Tout pour covoiturer intelligemment</h2>
            <p class="section-desc">Une plateforme complète qui simplifie la coordination entre collaborateurs d'une même zone.</p>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🤖</div>
                    <h3 class="feature-title">Score IA Expliqué</h3>
                    <p class="feature-desc">Analyse de zone géographique, entreprise, horaires et récurrences pour vous proposer les trajets les plus pertinents avec une justification transparente.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏢</div>
                    <h3 class="feature-title">Réseau Entreprises</h3>
                    <p class="feature-desc">Covoiturez avec vos collègues ou partenaires dans un cadre professionnel de confiance — MobiliTech, NextBuild, Atlas Digital et plus.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3 class="feature-title">Réservations Contrôlées</h3>
                    <p class="feature-desc">Statuts temps réel (en attente, confirmée, refusée) sans surréservation. Les conducteurs gèrent directement leurs passagers.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-brand">Co<span>Ride</span></div>
        <p>© 2026 MobiliTech — Plateforme sécurisée de mobilité durable d'entreprise.</p>
    </footer>

    <script>
        (function () {
            const html = document.documentElement;
            const btn  = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const KEY  = 'cr-theme';
            const saved = localStorage.getItem(KEY);
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyTheme(saved || (prefersDark ? 'dark' : 'light'));
            btn.addEventListener('click', function () {
                const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                applyTheme(next); localStorage.setItem(KEY, next);
            });
            function applyTheme(t) {
                html.setAttribute('data-theme', t);
                icon.textContent = t === 'dark' ? '☀️' : '🌙';
            }
        })();
    </script>
</body>
</html>
