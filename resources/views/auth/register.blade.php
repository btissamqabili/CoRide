<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf


        <!-- Nom -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error 
                :messages="$errors->get('name')" 
                class="mt-2" 
            />
        </div>



        <!-- Email professionnel -->
        <div class="mt-4">

            <x-input-label for="email" :value="__('Email professionnel')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error 
                :messages="$errors->get('email')" 
                class="mt-2" 
            />

        </div>




        <!-- Ville de résidence -->
        <div class="mt-4">

            <x-input-label 
                for="ville_residence" 
                :value="__('Ville de résidence')" 
            />

            <x-text-input
                id="ville_residence"
                class="block mt-1 w-full"
                type="text"
                name="ville_residence"
                :value="old('ville_residence')"
                required
            />

            <x-input-error 
                :messages="$errors->get('ville_residence')" 
                class="mt-2" 
            />

        </div>




        <!-- Entreprise -->
        <div class="mt-4">

            <x-input-label 
                for="entreprise_id" 
                :value="__('Entreprise')" 
            />


            <select
                id="entreprise_id"
                name="entreprise_id"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                required
            >

                <option value="">
                    -- Choisir une entreprise --
                </option>


                @foreach(\App\Models\Entreprise::all() as $entreprise)

                    <option 
                        value="{{ $entreprise->id }}"
                        {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}
                    >
                        {{ $entreprise->nom }}
                    </option>

                @endforeach


            </select>


            <x-input-error 
                :messages="$errors->get('entreprise_id')" 
                class="mt-2" 
            />

        </div>





        <!-- Role -->
        <div class="mt-4">


            <x-input-label 
                for="role" 
                :value="__('Rôle')" 
            />


            <select
                id="role"
                name="role"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                required
            >

                <option value="">
                    -- Choisir un rôle --
                </option>


                <option 
                    value="conducteur"
                    {{ old('role') == 'conducteur' ? 'selected' : '' }}
                >
                    Conducteur
                </option>


                <option 
                    value="passager"
                    {{ old('role') == 'passager' ? 'selected' : '' }}
                >
                    Passager
                </option>


                <option 
                    value="les_deux"
                    {{ old('role') == 'les_deux' ? 'selected' : '' }}
                >
                    Conducteur et Passager
                </option>


            </select>


            <x-input-error 
                :messages="$errors->get('role')" 
                class="mt-2" 
            />


        </div>





        <!-- Password -->
        <div class="mt-4">


            <x-input-label 
                for="password" 
                :value="__('Mot de passe')" 
            />


            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />


            <x-input-error 
                :messages="$errors->get('password')" 
                class="mt-2" 
            />


        </div>






        <!-- Confirmation Password -->
        <div class="mt-4">


            <x-input-label
                for="password_confirmation"
                :value="__('Confirmer le mot de passe')"
            />


            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />


            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />


        </div>






        <!-- Buttons -->
        <div class="flex items-center justify-end mt-4">


            <a
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}"
            >
                {{ __('Déjà inscrit ?') }}
            </a>



            <x-primary-button class="ms-4">

                {{ __('Créer un compte') }}

            </x-primary-button>


        </div>


    </form>

</x-guest-layout>