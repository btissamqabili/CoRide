<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Injecter les valeurs par défaut pour statut et date_reservation
     * si elles ne sont pas fournies par le formulaire HTML passager.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'statut'           => $this->input('statut', 'en_attente'),
            'date_reservation' => $this->input('date_reservation', now()->toDateTimeString()),
        ]);
    }

    public function rules(): array
    {
        return [
            'trajet_id'        => 'required|exists:trajets,id',
            'statut'           => 'required|in:en_attente,confirmee,refusee,annulee',
            'date_reservation' => 'required|date',
        ];
    }
}