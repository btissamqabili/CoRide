<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CoRide') }} — Authentification</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root, [data-theme="light"] {
            --bg-base:     #f8fafc;
            --bg-surface:  #ffffff;
            --bg-subtle:   #f1f5f9;
            --text-primary:#0d1117;
            --text-secondary:#4b5563;
            --text-muted:  #94a3b8;
            --border:      #e2e8f0;
            --red:         #e11d48;
            --red-dark:    #be123c;
            --red-light:   #fda4af;
            --red-bg:      #fff1f2;
        }
        [data-theme="dark"] {
            --bg-base:     #0d1117;
            --bg-surface:  #161b22;
            --bg-subtle:   #1c2128;
            --text-primary:#e6edf3;
            --text-secondary:#8b949e;
            --text-muted:  #484f58;
            --border:      #30363d;
            --red:         #f43f5e;
            --red-dark:    #e11d48;
            --red-light:   #fb7185;
            --red-bg:      rgba(225,29,72,0.12);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background:
                radial-gradient(ellipse 900px 600px at 100% 100%, rgba(225,29,72,0.06), transparent),
                radial-gradient(ellipse 600px 400px at 0% 0%, rgba(225,29,72,0.04), transparent),
                var(--bg-base);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 2rem 1rem;
            transition: background 0.3s ease, color 0.3s ease;
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        /* Topbar dark toggle */
        .auth-topbar {
            position: fixed; top: 1rem; right: 1rem;
        }
        .theme-toggle {
            width: 36px; height: 36px; border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--bg-surface);
            color: var(--text-secondary);
            cursor: pointer; font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .theme-toggle:hover { border-color: var(--red); color: var(--red); }

        .auth-logo {
            font-family: 'Sora', sans-serif;
            font-size: 2rem; font-weight: 800; letter-spacing: -0.5px;
            color: var(--text-primary); text-decoration: none;
            margin-bottom: 2rem; display: block; text-align: center;
        }
        .auth-logo span { color: var(--red); }

        .auth-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 2.25rem 2.5rem;
            width: 100%; max-width: 460px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .auth-card-wide { max-width: 560px; }

        .cr-label {
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.5px;
            text-transform: uppercase; color: var(--text-secondary);
            margin-bottom: 6px; display: block; font-family: 'DM Sans', sans-serif;
        }
        .cr-input {
            width: 100%; padding: 0.75rem 1rem;
            background: var(--bg-base);
            border: 1.5px solid var(--border);
            border-radius: 9px; color: var(--text-primary);
            font-size: 0.9rem; font-family: 'DM Sans', sans-serif;
            transition: all 0.2s ease; outline: none;
        }
        .cr-input:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(225,29,72,0.12); background: var(--bg-surface); }
        select.cr-input option { background: var(--bg-surface); color: var(--text-primary); }

        .btn-cr-submit {
            width: 100%; background: var(--red); color: #fff; border: none;
            padding: 0.875rem 1.5rem; border-radius: 9px; font-weight: 700; font-size: 1rem;
            cursor: pointer; transition: all 0.2s ease;
            box-shadow: 0 4px 16px rgba(225,29,72,0.3);
            margin-top: 1.5rem; font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.2px;
        }
        .btn-cr-submit:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 6px 24px rgba(225,29,72,0.4); }

        .auth-footer-link { color: var(--text-muted); font-size: 0.875rem; text-decoration: none; transition: color 0.2s; }
        .auth-footer-link:hover { color: var(--red); text-decoration: underline; }

        .error-msg { color: var(--red); font-size: 0.8rem; margin-top: 4px; }

        .auth-divider { height: 1px; background: var(--border); margin: 1.25rem 0; }

        p { color: var(--text-muted); }
    </style>
</head>
<body>
    <!-- Dark mode toggle fixe -->
    <div class="auth-topbar">
        <button class="theme-toggle" id="themeToggle" type="button" title="Changer le thème">
            <span id="themeIcon">🌙</span>
        </button>
    </div>

    <a href="/" class="auth-logo">Co<span>Ride</span></a>

    <div class="auth-card {{ request()->routeIs('register') ? 'auth-card-wide' : '' }}">
        {{ $slot }}
    </div>

    <p style="margin-top:2rem; font-size:0.8rem; text-align:center;">
        © 2026 MobiliTech — Plateforme de mobilité durable
    </p>

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
                applyTheme(next);
                localStorage.setItem(KEY, next);
            });
            function applyTheme(t) {
                html.setAttribute('data-theme', t);
                icon.textContent = t === 'dark' ? '☀️' : '🌙';
            }
        })();
    </script>
</body>
</html>
