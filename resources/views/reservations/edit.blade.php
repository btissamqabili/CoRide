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

                <div class="mb-3">

                    <label class="form-label">
                        Trajet
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $reservation->trajet->ville_depart }} → {{ $reservation->trajet->ville_arrivee }}"
                        readonly>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Passager
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $reservation->passager->name }}"
                        readonly>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Date de réservation
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $reservation->date_reservation }}"
                        readonly>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Statut
                    </label>

                    <select
                        name="statut"
                        class="form-select"
                        required>

                        <option value="en_attente"
                            {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>
                            En attente
                        </option>

                        <option value="confirmee"
                            {{ $reservation->statut == 'confirmee' ? 'selected' : '' }}>
                            Confirmée
                        </option>

                        <option value="refusee"
                            {{ $reservation->statut == 'refusee' ? 'selected' : '' }}>
                            Refusée
                        </option>

                        <option value="annulee"
                            {{ $reservation->statut == 'annulee' ? 'selected' : '' }}>
                            Annulée
                        </option>

                    </select>

                </div>

                <div class="d-flex justify-content-between">

                    <a href="{{ route('reservations.index') }}"
                       class="btn btn-secondary">
                        Retour
                    </a>

                    <button
                        type="submit"
                        class="btn btn-warning">

                        Mettre à jour

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection