<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    protected $fillable = [
        'conducteur_id',
        'ville_depart',
        'ville_arrivee',
        'date_depart',
        'heure_depart',
        'nombre_places',
        'description'
    ];

    public function conducteur()
    {
        return $this->belongsTo(User::class, 'conducteur_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}