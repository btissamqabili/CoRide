<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\CompatibilityService;

class CompatibilityController extends Controller
{
    public function show(Reservation $reservation, CompatibilityService $service)
    {
        $result = $service->generate($reservation);

        $reservation->compatibility = $result;

        $reservation->save();

        return view('compatibility.show', compact('reservation'));
    }
}