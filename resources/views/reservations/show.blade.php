@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-info text-white">
            <h3>Détails de la réservation</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="30%">Passager</th>
                    <td>{{ $reservation->passager->name }}</td>
                </tr>

                <tr>
                    <th>Conducteur</th>
                    <td>{{ $reservation->trajet->conducteur->name }}</td>
                </tr>

                <tr>
                    <th>Ville de départ</th>
                    <td>{{ $reservation->trajet->ville_depart }}</td>
                </tr>

                <tr>
                    <th>Ville d'arrivée</th>
                    <td>{{ $reservation->trajet->ville_arrivee }}</td>
                </tr>

                <tr>
                    <th>Horaire</th>
                    <td>{{ $reservation->trajet->horaire }}</td>
                </tr>

                <tr>
                    <th>Places disponibles</th>
                    <td>{{ $reservation->trajet->places_disponibles }}</td>
                </tr>

                <tr>
                    <th>Jours de récurrence</th>
                    <td>{{ $reservation->trajet->jours_recurrence }}</td>
                </tr>

                <tr>
                    <th>Statut</th>
                    <td>

                        @switch($reservation->statut)

                            @case('en_attente')
                                <span class="badge bg-warning text-dark">
                                    En attente
                                </span>
                                @break

                            @case('confirmee')
                                <span class="badge bg-success">
                                    Confirmée
                                </span>
                                @break

                            @case('refusee')
                                <span class="badge bg-danger">
                                    Refusée
                                </span>
                                @break

                            @case('annulee')
                                <span class="badge bg-secondary">
                                    Annulée
                                </span>
                                @break

                        @endswitch

                    </td>
                </tr>

                <tr>
                    <th>Date de réservation</th>
                    <td>{{ $reservation->date_reservation }}</td>
                </tr>

            </table>

            <div class="d-flex justify-content-between">

                <a href="{{ route('reservations.index') }}"
                   class="btn btn-secondary">
                    Retour
                </a>

                <div>

                    <a href="{{ route('reservations.edit', $reservation) }}"
                       class="btn btn-warning">
                        Modifier
                    </a>

                    <form action="{{ route('reservations.destroy', $reservation) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?')">

                            Supprimer

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection