<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trajet;
use App\Models\User;

class TrajetSeeder extends Seeder
{
    public function run(): void
    {
        // On récupère les conducteurs par email pour associer conducteur_id
        $conducteurs = User::whereIn('role', ['conducteur', 'les_deux'])->pluck('id', 'email');

        $trajets = [
            // Lyon ↔ Villeurbanne / Bron / Vénissieux
            ['conducteur' => 'alice.martin@mobilitech.com',    'depart' => 'Lyon',           'arrivee' => 'Villeurbanne',   'horaire' => '2026-08-04 08:00:00', 'places' => 3, 'jours' => 'Lundi, Mercredi, Vendredi'],
            ['conducteur' => 'david.renard@mobilitech.com',    'depart' => 'Vénissieux',     'arrivee' => 'Lyon',           'horaire' => '2026-08-04 07:30:00', 'places' => 2, 'jours' => 'Lundi, Mardi, Jeudi'],
            ['conducteur' => 'francois.morel@mobilitech.com',  'depart' => 'Caluire',        'arrivee' => 'Lyon',           'horaire' => '2026-08-05 08:15:00', 'places' => 4, 'jours' => 'Mardi, Jeudi'],
            ['conducteur' => 'hugo.bernard@mobilitech.com',    'depart' => 'Meyzieu',        'arrivee' => 'Lyon',           'horaire' => '2026-08-05 07:45:00', 'places' => 3, 'jours' => 'Lundi, Mercredi'],
            ['conducteur' => 'clara.dupont@mobilitech.com',    'depart' => 'Bron',           'arrivee' => 'Lyon',           'horaire' => '2026-08-06 08:30:00', 'places' => 2, 'jours' => 'Mercredi, Vendredi'],

            // Grenoble zone
            ['conducteur' => 'ines.thomas@nextbuild.com',      'depart' => 'Grenoble',       'arrivee' => 'Échirolles',     'horaire' => '2026-08-04 08:00:00', 'places' => 3, 'jours' => 'Lundi, Mercredi, Vendredi'],
            ['conducteur' => 'luc.fontaine@nextbuild.com',     'depart' => 'Grenoble',       'arrivee' => 'Meylan',         'horaire' => '2026-08-04 07:45:00', 'places' => 2, 'jours' => 'Mardi, Jeudi'],
            ['conducteur' => 'karen.mercier@nextbuild.com',    'depart' => 'Meylan',         'arrivee' => 'Grenoble',       'horaire' => '2026-08-05 08:00:00', 'places' => 3, 'jours' => 'Lundi, Mercredi'],
            ['conducteur' => 'pierre.girard@nextbuild.com',    'depart' => 'Pontcharra',     'arrivee' => 'Grenoble',       'horaire' => '2026-08-05 07:15:00', 'places' => 4, 'jours' => 'Lundi, Mardi, Jeudi, Vendredi'],
            ['conducteur' => 'nicolas.roux@nextbuild.com',     'depart' => 'Voreppe',        'arrivee' => 'Grenoble',       'horaire' => '2026-08-06 08:00:00', 'places' => 2, 'jours' => 'Mercredi, Vendredi'],

            // Bordeaux zone
            ['conducteur' => 'rania.chevalier@atlasdigital.com','depart' => 'Mérignac',     'arrivee' => 'Bordeaux',       'horaire' => '2026-08-04 08:30:00', 'places' => 3, 'jours' => 'Lundi, Mercredi, Vendredi'],
            ['conducteur' => 'ugo.masson@atlasdigital.com',    'depart' => 'Bordeaux',       'arrivee' => 'Pessac',         'horaire' => '2026-08-04 07:30:00', 'places' => 2, 'jours' => 'Mardi, Jeudi'],
            ['conducteur' => 'quentin.bonnet@atlasdigital.com','depart' => 'Bordeaux',       'arrivee' => 'Talence',        'horaire' => '2026-08-05 08:00:00', 'places' => 4, 'jours' => 'Lundi, Mercredi'],
            ['conducteur' => 'tina.rousseau@atlasdigital.com', 'depart' => 'Talence',        'arrivee' => 'Bordeaux',       'horaire' => '2026-08-06 07:45:00', 'places' => 2, 'jours' => 'Lundi, Vendredi'],
            ['conducteur' => 'xenia.perrin@atlasdigital.com',  'depart' => 'Pessac',         'arrivee' => 'Bordeaux',       'horaire' => '2026-08-07 08:15:00', 'places' => 3, 'jours' => 'Mardi, Jeudi, Vendredi'],

            // Nantes zone
            ['conducteur' => 'yasmine.moreau@greenlogix.com',  'depart' => 'Nantes',         'arrivee' => 'Saint-Herblain', 'horaire' => '2026-08-04 08:00:00', 'places' => 3, 'jours' => 'Lundi, Mardi, Mercredi'],
            ['conducteur' => 'baptiste.marchal@greenlogix.com','depart' => 'Nantes',         'arrivee' => 'Rezé',           'horaire' => '2026-08-04 07:30:00', 'places' => 2, 'jours' => 'Mardi, Jeudi'],
            ['conducteur' => 'ambre.colin@greenlogix.com',     'depart' => 'Rezé',           'arrivee' => 'Nantes',         'horaire' => '2026-08-05 08:00:00', 'places' => 3, 'jours' => 'Lundi, Mercredi, Vendredi'],
            ['conducteur' => 'dorian.perez@greenlogix.com',    'depart' => 'Bouguenais',     'arrivee' => 'Nantes',         'horaire' => '2026-08-05 07:15:00', 'places' => 4, 'jours' => 'Lundi, Jeudi'],
            ['conducteur' => 'fabien.bertrand@greenlogix.com', 'depart' => 'Saint-Sébastien','arrivee' => 'Nantes',         'horaire' => '2026-08-06 08:30:00', 'places' => 2, 'jours' => 'Mercredi, Vendredi'],

            // Marseille / Aix zone
            ['conducteur' => 'gina.aubert@kandia.com',         'depart' => 'Marseille',      'arrivee' => 'Aix-en-Provence','horaire' => '2026-08-04 07:45:00', 'places' => 3, 'jours' => 'Lundi, Mercredi, Vendredi'],
            ['conducteur' => 'hassan.caron@kandia.com',        'depart' => 'Aix-en-Provence','arrivee' => 'Marseille',      'horaire' => '2026-08-04 08:15:00', 'places' => 2, 'jours' => 'Mardi, Jeudi'],
            ['conducteur' => 'jordan.dupuis@kandia.com',       'depart' => 'Marseille',      'arrivee' => 'Aubagne',        'horaire' => '2026-08-05 07:30:00', 'places' => 4, 'jours' => 'Lundi, Mardi, Mercredi'],
            ['conducteur' => 'kylian.vasseur@kandia.com',      'depart' => 'Vitrolles',      'arrivee' => 'Marseille',      'horaire' => '2026-08-05 07:00:00', 'places' => 3, 'jours' => 'Lundi, Mercredi, Vendredi'],
            ['conducteur' => 'mehdi.roger@kandia.com',         'depart' => 'Marseille',      'arrivee' => 'Martigues',      'horaire' => '2026-08-06 08:00:00', 'places' => 2, 'jours' => 'Mardi, Jeudi, Vendredi'],
        ];

        foreach ($trajets as $data) {
            Trajet::create([
                'conducteur_id'     => $conducteurs[$data['conducteur']],
                'ville_depart'      => $data['depart'],
                'ville_arrivee'     => $data['arrivee'],
                'horaire'           => $data['horaire'],
                'places_disponibles'=> $data['places'],
                'jours_recurrence'  => $data['jours'],
            ]);
        }
    }
}
