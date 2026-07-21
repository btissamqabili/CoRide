<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'ville_residence',
    'role',
    'entreprise_id'
])]

#[Hidden([
    'password',
    'remember_token'
])]

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relation : un employé appartient à une entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    // Relation : un employé (conducteur) possède plusieurs trajets
    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'conducteur_id');
    }

    // Relation : un employé (passager) possède plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'passager_id');
    }
}