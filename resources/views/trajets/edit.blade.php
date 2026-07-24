@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h3>Modifier un trajet</h3>
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

            <form action="{{ route('trajets.update', $trajet) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Ville de départ</label>

                    <input
                        type="text"
                        name="ville_depart"
                        class="form-control"
                        value="{{ old('ville_depart', $trajet->ville_depart) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ville d'arrivée</label>

                    <input
                        type="text"
                        name="ville_arrivee"
                        class="form-control"
                        value="{{ old('ville_arrivee', $trajet->ville_arrivee) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Horaire</label>

                    <input
                        type="datetime-local"
                        name="horaire"
                        class="form-control"
                        value="{{ old('horaire', $trajet->horaire) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Places disponibles</label>

                    <input
                        type="number"
                        name="places_disponibles"
                        class="form-control"
                        min="1"
                        value="{{ old('places_disponibles', $trajet->places_disponibles) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jours de récurrence</label>

                    <input
                        type="text"
                        name="jours_recurrence"
                        class="form-control"
                        value="{{ old('jours_recurrence', $trajet->jours_recurrence) }}">
                </div>

                <div class="d-flex justify-content-between">

                    <a href="{{ route('trajets.index') }}"
                       class="btn btn-secondary">
                        Retour
                    </a>

                    <button type="submit"
                            class="btn btn-warning">
                        Modifier le trajet
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection