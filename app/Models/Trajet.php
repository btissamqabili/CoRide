<?php

namespace App\Models;

use App\Casts\ScoreCompatibilite;
use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    protected $fillable = [
        'conducteur_id',
        'ville_depart',
        'ville_arrivee',
        'horaire',
        'places_disponibles',
        'jours_recurrence',
        'score_ia',
    ];

    /**
     * Cast Eloquent : le champ score_ia est automatiquement
     * sérialisé/désérialisé via ScoreCompatibilite.
     */
    protected function casts(): array
    {
        return [
            'score_ia' => ScoreCompatibilite::class,
            'horaire'  => 'datetime',
        ];
    }

    public function conducteur()
    {
        return $this->belongsTo(User::class, 'conducteur_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Nombre de places encore disponibles (places - réservations confirmées).
     */
    public function placesRestantes(): int
    {
        return max(0, $this->places_disponibles - $this->reservations()->where('statut', 'confirmee')->count());
    }
}