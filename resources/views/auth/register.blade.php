<x-guest-layout>

    <div style="text-align:center; margin-bottom:1.75rem;">
        <h1 style="font-size:1.5rem; font-weight:800; color:white; margin:0 0 0.5rem;">Créer un compte Salarié</h1>
        <p style="color:#94a3b8; font-size:0.875rem; margin:0;">Rejoignez le réseau de covoiturage CoRide de votre entreprise</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
            <!-- Nom -->
            <div>
                <label for="name" class="cr-label">Nom complet <span style="color:#ef4444;">*</span></label>
                <input id="name" type="text" name="name" class="cr-input" value="{{ old('name') }}" required autofocus placeholder="ex: Alice Martin">
                @if($errors->has('name'))
                    <div class="error-msg">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <!-- Email professionnel -->
            <div>
                <label for="email" class="cr-label">Email professionnel <span style="color:#ef4444;">*</span></label>
                <input id="email" type="email" name="email" class="cr-input" value="{{ old('email') }}" required placeholder="nom@entreprise.com">
                @if($errors->has('email'))
                    <div class="error-msg">{{ $errors->first('email') }}</div>
                @endif
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
            <!-- Ville de résidence -->
            <div>
                <label for="ville_residence" class="cr-label">Ville de résidence <span style="color:#ef4444;">*</span></label>
                <input id="ville_residence" type="text" name="ville_residence" class="cr-input" value="{{ old('ville_residence') }}" required placeholder="ex: Lyon">
                @if($errors->has('ville_residence'))
                    <div class="error-msg">{{ $errors->first('ville_residence') }}</div>
                @endif
            </div>

            <!-- Entreprise -->
            <div>
                <label for="entreprise_id" class="cr-label">Entreprise partenaire <span style="color:#ef4444;">*</span></label>
                <select id="entreprise_id" name="entreprise_id" class="cr-input" required>
                    <option value="">-- Choisir une entreprise --</option>
                    @foreach(\App\Models\Entreprise::all() as $entreprise)
                        <option value="{{ $entreprise->id }}" {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}>
                            {{ $entreprise->nom }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('entreprise_id'))
                    <div class="error-msg">{{ $errors->first('entreprise_id') }}</div>
                @endif
            </div>
        </div>

        <!-- Rôle -->
        <div style="margin-bottom:1rem;">
            <label for="role" class="cr-label">Rôle d'utilisation <span style="color:#ef4444;">*</span></label>
            <select id="role" name="role" class="cr-input" required>
                <option value="">-- Choisir votre rôle --</option>
                <option value="conducteur" {{ old('role') == 'conducteur' ? 'selected' : '' }}>🚘 Conducteur (Propose des trajets)</option>
                <option value="passager" {{ old('role') == 'passager' ? 'selected' : '' }}>🧳 Passager (Recherche des trajets)</option>
                <option value="les_deux" {{ old('role') == 'les_deux' ? 'selected' : '' }}>🚘🧳 Les deux (Conducteur et Passager)</option>
            </select>
            @if($errors->has('role'))
                <div class="error-msg">{{ $errors->first('role') }}</div>
            @endif
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.25rem;">
            <!-- Password -->
            <div>
                <label for="password" class="cr-label">Mot de passe <span style="color:#ef4444;">*</span></label>
                <input id="password" type="password" name="password" class="cr-input" required autocomplete="new-password">
                @if($errors->has('password'))
                    <div class="error-msg">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <!-- Confirmation Password -->
            <div>
                <label for="password_confirmation" class="cr-label">Confirmer le mot de passe <span style="color:#ef4444;">*</span></label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="cr-input" required autocomplete="new-password">
                @if($errors->has('password_confirmation'))
                    <div class="error-msg">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>
        </div>

        <button type="submit" class="btn-cr-submit">
            🚀 Créer mon compte CoRide
        </button>

        <div style="text-align:center; margin-top:1.25rem;">
            <a class="auth-footer-link" href="{{ route('login') }}">
                Déjà un compte ? Se connecter →
            </a>
        </div>
    </form>

</x-guest-layout>