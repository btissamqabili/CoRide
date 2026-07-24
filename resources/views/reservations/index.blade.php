@extends('layouts.app')

@section('content')

<div class="container mt-5">

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Liste des réservations</h2>

        <a href="{{ route('reservations.create') }}"
           class="btn btn-success">
            + Nouvelle réservation
        </a>

    </div>

    @if($reservations->count() > 0)

        <table class="table table-bordered table-hover shadow">

            <thead class="table-dark">

                <tr>
                    <th>Passager</th>
                    <th>Conducteur</th>
                    <th>Ville départ</th>
                    <th>Ville arrivée</th>
                    <th>Statut</th>
                    <th>Date de réservation</th>
                    <th width="220">Actions</th>
                </tr>

            </thead>

            <tbody>

                @foreach($reservations as $reservation)

                    <tr>

                        <td>
                            {{ $reservation->passager->name }}
                        </td>

                        <td>
                            {{ $reservation->trajet->conducteur->name }}
                        </td>

                        <td>
                            {{ $reservation->trajet->ville_depart }}
                        </td>

                        <td>
                            {{ $reservation->trajet->ville_arrivee }}
                        </td>

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

                        <td>
                            {{ $reservation->date_reservation }}
                        </td>

                        <td>

                            <a href="{{ route('reservations.show',$reservation) }}"
                               class="btn btn-info btn-sm">
                                Voir
                            </a>

                            <a href="{{ route('reservations.edit',$reservation) }}"
                               class="btn btn-warning btn-sm">
                                Modifier
                            </a>

                            <form action="{{ route('reservations.destroy',$reservation) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Supprimer cette réservation ?')">

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

            Aucune réservation disponible.

        </div>

    @endif

</div>

@endsection