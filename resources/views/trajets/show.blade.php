@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-info text-white">
            <h3>Détails du trajet</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="30%">Conducteur</th>
                    <td>{{ $trajet->conducteur->name }}</td>
                </tr>

                <tr>
                    <th>Ville de départ</th>
                    <td>{{ $trajet->ville_depart }}</td>
                </tr>

                <tr>
                    <th>Ville d'arrivée</th>
                    <td>{{ $trajet->ville_arrivee }}</td>
                </tr>

                <tr>
                    <th>Horaire</th>
                    <td>{{ $trajet->horaire }}</td>
                </tr>

                <tr>
                    <th>Places disponibles</th>
                    <td>{{ $trajet->places_disponibles }}</td>
                </tr>

                <tr>
                    <th>Jours de récurrence</th>
                    <td>{{ $trajet->jours_recurrence }}</td>
                </tr>

            </table>

            <div class="d-flex justify-content-between">

                <a href="{{ route('trajets.index') }}"
                   class="btn btn-secondary">
                    Retour
                </a>

                <div>

                    <a href="{{ route('trajets.edit', $trajet) }}"
                       class="btn btn-warning">
                        Modifier
                    </a>

                    <form action="{{ route('trajets.destroy', $trajet) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Voulez-vous vraiment supprimer ce trajet ?')">

                            Supprimer

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection