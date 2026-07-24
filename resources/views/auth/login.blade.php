<x-guest-layout>

    <div style="text-align:center; margin-bottom:1.75rem;">
        <h1 style="font-size:1.5rem; font-weight:800; color:white; margin:0 0 0.5rem;">Connexion CoRide</h1>
        <p style="color:#94a3b8; font-size:0.875rem; margin:0;">Accédez à votre espace covoiturage entreprise</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div style="background:#d1fae5; color:#065f46; border-left:4px solid #10b981; padding:0.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:0.85rem;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom:1.25rem;">
            <label for="email" class="cr-label">Email professionnel</label>
            <input id="email" type="email" name="email" class="cr-input" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nom@entreprise.com">
            @if($errors->has('email'))
                <div class="error-msg">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <!-- Password -->
        <div style="margin-bottom:1.25rem;">
            <label for="password" class="cr-label">Mot de passe</label>
            <input id="password" type="password" name="password" class="cr-input" required autocomplete="current-password" placeholder="••••••••">
            @if($errors->has('password'))
                <div class="error-msg">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <!-- Remember Me -->
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
            <label for="remember_me" style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.85rem; color:#cbd5e1;">
                <input id="remember_me" type="checkbox" name="remember" style="width:16px; height:16px; accent-color:#6366f1;">
                Se souvenir de moi
            </label>

            @if (Route::has('password.request'))
                <a class="auth-footer-link" href="{{ route('password.request') }}" style="font-size:0.8rem;">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-cr-submit">
            🔑 Se connecter
        </button>

        <div style="text-align:center; margin-top:1.5rem;">
            <a class="auth-footer-link" href="{{ route('register') }}">
                Pas encore de compte ? S'inscrire →
            </a>
        </div>
    </form>
</x-guest-layout>
