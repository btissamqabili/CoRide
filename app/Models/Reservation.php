<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'trajet_id',
        'passager_id',
        'statut',
        'date_reservation',
    ];

    public function trajet()
    {
        return $this->belongsTo(Trajet::class);
    }

    public function passager()
    {
        return $this->belongsTo(User::class, 'passager_id');
    }
    protected function casts(): array
{
    return [
        'compatibility' => CompatibilityCast::class,
    ];
}
}

