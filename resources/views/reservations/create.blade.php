@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h3>Nouvelle réservation</h3>
        </div>

        <div class="card-body">

            {{-- Affichage des erreurs --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('reservations.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Choisir un trajet
                    </label>

                    <select name="trajet_id" class="form-select" required>

                        <option value="">
                            -- Sélectionner un trajet --
                        </option>

                        @foreach($trajets as $trajet)

                            <option
                                value="{{ $trajet->id }}"
                                {{ old('trajet_id') == $trajet->id ? 'selected' : '' }}>

                                {{ $trajet->ville_depart }}
                                →
                                {{ $trajet->ville_arrivee }}
                                |
                                {{ $trajet->horaire }}
                                |
                                Places :
                                {{ $trajet->places_disponibles }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="d-flex justify-content-between">

                    <a href="{{ route('reservations.index') }}"
                       class="btn btn-secondary">

                        Retour

                    </a>

                    <button type="submit"
                            class="btn btn-success">

                        Réserver

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection