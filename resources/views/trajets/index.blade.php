@extends('layouts.app')

@section('content')

<div class="container mt-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des trajets</h2>

        <a href="{{ route('trajets.create') }}" class="btn btn-success">
            + Publier un trajet
        </a>
    </div>

    @if($trajets->count() > 0)

        <table class="table table-striped table-bordered shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>Conducteur</th>
                    <th>Ville de départ</th>
                    <th>Ville d'arrivée</th>
                    <th>Horaire</th>
                    <th>Places</th>
                    <th>Jours de récurrence</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($trajets as $trajet)

                    <tr>

                        <td>{{ $trajet->conducteur->name }}</td>

                        <td>{{ $trajet->ville_depart }}</td>

                        <td>{{ $trajet->ville_arrivee }}</td>

                        <td>{{ $trajet->horaire }}</td>

                        <td>{{ $trajet->places_disponibles }}</td>

                        <td>{{ $trajet->jours_recurrence }}</td>

                        <td class="text-center">

                            <a href="{{ route('trajets.show',$trajet) }}"
                               class="btn btn-info btn-sm">
                                Voir
                            </a>

                            <a href="{{ route('trajets.edit',$trajet) }}"
                               class="btn btn-warning btn-sm">
                                Modifier
                            </a>

                            <form action="{{ route('trajets.destroy',$trajet) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Voulez-vous vraiment supprimer ce trajet ?')">

                                    Supprimer

                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <div class="alert alert-info text-center">
            Aucun trajet disponible pour le moment.
        </div>

    @endif

</div>

@endsection