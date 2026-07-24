<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrajetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ville_depart' => 'required|string|max:255',
            'ville_arrivee' => 'required|string|max:255',
            'horaire' => 'required|date',
            'places_disponibles' => 'required|integer|min:1',
            'jours_recurrence' => 'nullable|string|max:255',
        ];
    }
}