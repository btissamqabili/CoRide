@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <h2 class="mb-4">Tableau de bord CoRide</h2>

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card text-center shadow border-primary">
                <div class="card-body">
                    <h5 class="card-title">Trajets</h5>
                    <h2>{{ $nbTrajets }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center shadow border-success">
                <div class="card-body">
                    <h5 class="card-title">Réservations</h5>
                    <h2>{{ $nbReservations }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center shadow border-warning">
                <div class="card-body">
                    <h5 class="card-title">Employés</h5>
                    <h2>{{ $nbEmployes }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center shadow border-danger">
                <div class="card-body">
                    <h5 class="card-title">Entreprises</h5>
                    <h2>{{ $nbEntreprises }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            Accès rapide
        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-3">

                <a href="{{ route('trajets.index') }}"
                   class="btn btn-primary">
                    Voir les trajets
                </a>

                <a href="{{ route('trajets.create') }}"
                   class="btn btn-success">
                    Publier un trajet
                </a>

                <a href="{{ route('reservations.index') }}"
                   class="btn btn-warning">
                    Mes réservations
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="btn btn-secondary">
                    Mon profil
                </a>

            </div>

        </div>

    </div>

</div>

@endsection