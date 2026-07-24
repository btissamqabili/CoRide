@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h3>Modifier une réservation</h3>
        </div>

        <div class="card-body">

            {{-- Affichage des erreurs --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reservations.update', $reservation) }}" method="POST">

                @csrf
                @method('PUT')

                {{-- Trajet --}}
                <div class="mb-3">
                    <label class="form-label">Trajet</label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $reservation->trajet->ville_depart }} → {{ $reservation->trajet->ville_arrivee }}"
                        readonly>
                </div>

                {{-- Passager --}}
                <div class="mb-3">
                    <label class="form-label">Passager</label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $reservation->passager->name }}"
                        readonly>
                </div>

                {{-- Date --}}
                <div class="mb-3">
                    <label class="form-label">Date de réservation</label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $reservation->date_reservation }}"
                        readonly>
                </div>

                {{-- Statut --}}
                <div class="mb-3">
                    <label for="statut" class="form-label">
                        Statut
                    </label>

                    <select
                        id="statut"
                        name="statut"
                        class="form-select @error('statut') is-invalid @enderror"
                        required>

                        <option value="en_attente"
                            {{ old('statut', $reservation->statut) == 'en_attente' ? 'selected' : '' }}>
                            En attente
                        </option>

                        <option value="confirmee"
                            {{ old('statut', $reservation->statut) == 'confirmee' ? 'selected' : '' }}>
                            Confirmée
                        </option>

                        <option value="refusee"
                            {{ old('statut', $reservation->statut) == 'refusee' ? 'selected' : '' }}>
                            Refusée
                        </option>

                        <option value="annulee"
                            {{ old('statut', $reservation->statut) == 'annulee' ? 'selected' : '' }}>
                            Annulée
                        </option>

                    </select>

                    @error('statut')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="d-flex justify-content-between">

                    <a href="{{ route('reservations.index') }}"
                       class="btn btn-secondary">
                        Retour
                    </a>

                    <button type="submit" class="btn btn-warning">
                        Mettre à jour
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection