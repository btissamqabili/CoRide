<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $passagers = User::whereIn('role', ['passager', 'les_deux'])->get()->keyBy('email');
        $trajets   = Trajet::with('conducteur')->get();

        // Helper : trouve trajet par ville départ
        $trajet = fn(string $depart, string $arrivee) => $trajets->first(
            fn($t) => $t->ville_depart === $depart && $t->ville_arrivee === $arrivee
        );

        $reservations = [
            // ---- Confirmées (trajets complets testés) ----
            ['trajet' => $trajet('Lyon', 'Villeurbanne'),      'passager' => 'bruno.leroy@mobilitech.com',      'statut' => 'confirmee',  'date' => '2026-07-20 10:00:00'],
            ['trajet' => $trajet('Lyon', 'Villeurbanne'),      'passager' => 'emma.blanc@mobilitech.com',       'statut' => 'confirmee',  'date' => '2026-07-20 11:00:00'],
            ['trajet' => $trajet('Lyon', 'Villeurbanne'),      'passager' => 'gaelle.simon@mobilitech.com',     'statut' => 'confirmee',  'date' => '2026-07-21 09:00:00'],
            // trajet Lyon→Villeurbanne = 3 places / 3 confirmées → complet ✓
            ['trajet' => $trajet('Vénissieux', 'Lyon'),        'passager' => 'clara.dupont@mobilitech.com',     'statut' => 'confirmee',  'date' => '2026-07-21 10:00:00'],
            ['trajet' => $trajet('Vénissieux', 'Lyon'),        'passager' => 'francois.morel@mobilitech.com',   'statut' => 'confirmee',  'date' => '2026-07-21 10:30:00'],
            ['trajet' => $trajet('Grenoble', 'Échirolles'),    'passager' => 'julien.petit@nextbuild.com',      'statut' => 'confirmee',  'date' => '2026-07-21 11:00:00'],
            ['trajet' => $trajet('Grenoble', 'Meylan'),        'passager' => 'karen.mercier@nextbuild.com',     'statut' => 'confirmee',  'date' => '2026-07-22 08:00:00'],
            ['trajet' => $trajet('Pontcharra', 'Grenoble'),    'passager' => 'marie.garnier@nextbuild.com',     'statut' => 'confirmee',  'date' => '2026-07-22 09:00:00'],
            ['trajet' => $trajet('Pontcharra', 'Grenoble'),    'passager' => 'oceane.lambert@nextbuild.com',    'statut' => 'confirmee',  'date' => '2026-07-22 09:30:00'],
            ['trajet' => $trajet('Mérignac', 'Bordeaux'),      'passager' => 'samuel.faure@atlasdigital.com',   'statut' => 'confirmee',  'date' => '2026-07-21 10:00:00'],
            ['trajet' => $trajet('Bordeaux', 'Pessac'),        'passager' => 'vera.nicolas@atlasdigital.com',   'statut' => 'confirmee',  'date' => '2026-07-22 10:00:00'],
            ['trajet' => $trajet('Nantes', 'Saint-Herblain'),  'passager' => 'zacharie.lemaire@greenlogix.com', 'statut' => 'confirmee',  'date' => '2026-07-21 11:00:00'],
            ['trajet' => $trajet('Nantes', 'Rezé'),            'passager' => 'camille.barbier@greenlogix.com',  'statut' => 'confirmee',  'date' => '2026-07-22 08:00:00'],
            ['trajet' => $trajet('Rezé', 'Nantes'),            'passager' => 'elise.roy@greenlogix.com',        'statut' => 'confirmee',  'date' => '2026-07-22 09:00:00'],
            ['trajet' => $trajet('Marseille', 'Aix-en-Provence'), 'passager' => 'iris.morin@kandia.com',       'statut' => 'confirmee',  'date' => '2026-07-21 08:00:00'],
            ['trajet' => $trajet('Aix-en-Provence', 'Marseille'), 'passager' => 'lea.arnaud@kandia.com',       'statut' => 'confirmee',  'date' => '2026-07-22 10:00:00'],
            ['trajet' => $trajet('Vitrolles', 'Marseille'),    'passager' => 'nina.schmitt@kandia.com',         'statut' => 'confirmee',  'date' => '2026-07-22 09:00:00'],

            // ---- En attente ----
            ['trajet' => $trajet('Caluire', 'Lyon'),           'passager' => 'emma.blanc@mobilitech.com',       'statut' => 'en_attente', 'date' => '2026-07-23 08:00:00'],
            ['trajet' => $trajet('Meyzieu', 'Lyon'),           'passager' => 'gaelle.simon@mobilitech.com',     'statut' => 'en_attente', 'date' => '2026-07-23 09:00:00'],
            ['trajet' => $trajet('Voreppe', 'Grenoble'),       'passager' => 'julien.petit@nextbuild.com',      'statut' => 'en_attente', 'date' => '2026-07-23 10:00:00'],
            ['trajet' => $trajet('Bordeaux', 'Talence'),       'passager' => 'william.guerin@atlasdigital.com', 'statut' => 'en_attente', 'date' => '2026-07-23 11:00:00'],
            ['trajet' => $trajet('Bouguenais', 'Nantes'),      'passager' => 'zacharie.lemaire@greenlogix.com', 'statut' => 'en_attente', 'date' => '2026-07-24 08:00:00'],
            ['trajet' => $trajet('Marseille', 'Aubagne'),      'passager' => 'jordan.dupuis@kandia.com',        'statut' => 'en_attente', 'date' => '2026-07-24 09:00:00'],
            ['trajet' => $trajet('Marseille', 'Martigues'),    'passager' => 'gina.aubert@kandia.com',          'statut' => 'en_attente', 'date' => '2026-07-24 10:00:00'],

            // ---- Refusées ----
            ['trajet' => $trajet('Bron', 'Lyon'),              'passager' => 'bruno.leroy@mobilitech.com',      'statut' => 'refusee',    'date' => '2026-07-20 14:00:00'],
            ['trajet' => $trajet('Pessac', 'Bordeaux'),        'passager' => 'william.guerin@atlasdigital.com', 'statut' => 'refusee',    'date' => '2026-07-20 15:00:00'],
            ['trajet' => $trajet('Nantes', 'Saint-Herblain'),  'passager' => 'dorian.perez@greenlogix.com',     'statut' => 'refusee',    'date' => '2026-07-21 14:00:00'],
            ['trajet' => $trajet('Grenoble', 'Échirolles'),    'passager' => 'nicolas.roux@nextbuild.com',      'statut' => 'refusee',    'date' => '2026-07-21 16:00:00'],

            // ---- Annulées ----
            ['trajet' => $trajet('Caluire', 'Lyon'),           'passager' => 'gaelle.simon@mobilitech.com',     'statut' => 'annulee',    'date' => '2026-07-19 10:00:00'],
            ['trajet' => $trajet('Meylan', 'Grenoble'),        'passager' => 'oceane.lambert@nextbuild.com',    'statut' => 'annulee',    'date' => '2026-07-19 11:00:00'],
            ['trajet' => $trajet('Talence', 'Bordeaux'),       'passager' => 'tina.rousseau@atlasdigital.com',  'statut' => 'annulee',    'date' => '2026-07-19 12:00:00'],
            ['trajet' => $trajet('Saint-Sébastien', 'Nantes'), 'passager' => 'camille.barbier@greenlogix.com',  'statut' => 'annulee',    'date' => '2026-07-19 13:00:00'],
            ['trajet' => $trajet('Marseille', 'Aix-en-Provence'), 'passager' => 'mehdi.roger@kandia.com',      'statut' => 'annulee',    'date' => '2026-07-19 14:00:00'],
            ['trajet' => $trajet('Vitrolles', 'Marseille'),    'passager' => 'jordan.dupuis@kandia.com',        'statut' => 'annulee',    'date' => '2026-07-19 15:00:00'],
            ['trajet' => $trajet('Pontcharra', 'Grenoble'),    'passager' => 'karen.mercier@nextbuild.com',     'statut' => 'annulee',    'date' => '2026-07-19 16:00:00'],
        ];

        foreach ($reservations as $data) {
            if (!$data['trajet']) continue;
            $passager = $passagers[$data['passager']] ?? null;
            if (!$passager) continue;
            // Skip si le passager est le conducteur du trajet
            if ($data['trajet']->conducteur_id === $passager->id) continue;

            // Éviter les doublons (unique trajet_id + passager_id)
            $exists = Reservation::where('trajet_id', $data['trajet']->id)
                ->where('passager_id', $passager->id)
                ->exists();
            if ($exists) continue;

            Reservation::create([
                'trajet_id'        => $data['trajet']->id,
                'passager_id'      => $passager->id,
                'statut'           => $data['statut'],
                'date_reservation' => $data['date'],
            ]);
        }
    }
}
