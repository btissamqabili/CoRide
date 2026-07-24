<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Hash;

class EmployeSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les IDs des entreprises
        $e = Entreprise::pluck('id', 'nom');

        $employes = [
            // MobiliTech (8 employés)
            ['name' => 'Alice Martin',     'email' => 'alice.martin@mobilitech.com',    'ville_residence' => 'Lyon',          'role' => 'conducteur',  'entreprise' => 'MobiliTech'],
            ['name' => 'Bruno Leroy',      'email' => 'bruno.leroy@mobilitech.com',     'ville_residence' => 'Villeurbanne',   'role' => 'passager',    'entreprise' => 'MobiliTech'],
            ['name' => 'Clara Dupont',     'email' => 'clara.dupont@mobilitech.com',    'ville_residence' => 'Bron',           'role' => 'les_deux',    'entreprise' => 'MobiliTech'],
            ['name' => 'David Renard',     'email' => 'david.renard@mobilitech.com',    'ville_residence' => 'Vénissieux',     'role' => 'conducteur',  'entreprise' => 'MobiliTech'],
            ['name' => 'Emma Blanc',       'email' => 'emma.blanc@mobilitech.com',      'ville_residence' => 'Décines',        'role' => 'passager',    'entreprise' => 'MobiliTech'],
            ['name' => 'François Morel',   'email' => 'francois.morel@mobilitech.com',  'ville_residence' => 'Caluire',        'role' => 'les_deux',    'entreprise' => 'MobiliTech'],
            ['name' => 'Gaëlle Simon',     'email' => 'gaelle.simon@mobilitech.com',    'ville_residence' => 'Saint-Priest',   'role' => 'passager',    'entreprise' => 'MobiliTech'],
            ['name' => 'Hugo Bernard',     'email' => 'hugo.bernard@mobilitech.com',    'ville_residence' => 'Meyzieu',        'role' => 'conducteur',  'entreprise' => 'MobiliTech'],

            // NextBuild (8 employés)
            ['name' => 'Inès Thomas',      'email' => 'ines.thomas@nextbuild.com',      'ville_residence' => 'Grenoble',       'role' => 'conducteur',  'entreprise' => 'NextBuild'],
            ['name' => 'Julien Petit',     'email' => 'julien.petit@nextbuild.com',     'ville_residence' => 'Échirolles',     'role' => 'passager',    'entreprise' => 'NextBuild'],
            ['name' => 'Karen Mercier',    'email' => 'karen.mercier@nextbuild.com',    'ville_residence' => 'Meylan',         'role' => 'les_deux',    'entreprise' => 'NextBuild'],
            ['name' => 'Luc Fontaine',     'email' => 'luc.fontaine@nextbuild.com',     'ville_residence' => 'Grenoble',       'role' => 'conducteur',  'entreprise' => 'NextBuild'],
            ['name' => 'Marie Garnier',    'email' => 'marie.garnier@nextbuild.com',    'ville_residence' => 'Crolles',        'role' => 'passager',    'entreprise' => 'NextBuild'],
            ['name' => 'Nicolas Roux',     'email' => 'nicolas.roux@nextbuild.com',     'ville_residence' => 'Voreppe',        'role' => 'les_deux',    'entreprise' => 'NextBuild'],
            ['name' => 'Océane Lambert',   'email' => 'oceane.lambert@nextbuild.com',   'ville_residence' => 'Vizille',        'role' => 'passager',    'entreprise' => 'NextBuild'],
            ['name' => 'Pierre Girard',    'email' => 'pierre.girard@nextbuild.com',    'ville_residence' => 'Pontcharra',     'role' => 'conducteur',  'entreprise' => 'NextBuild'],

            // Atlas Digital (8 employés)
            ['name' => 'Quentin Bonnet',   'email' => 'quentin.bonnet@atlasdigital.com','ville_residence' => 'Bordeaux',       'role' => 'les_deux',    'entreprise' => 'Atlas Digital'],
            ['name' => 'Rania Chevalier',  'email' => 'rania.chevalier@atlasdigital.com','ville_residence' => 'Mérignac',     'role' => 'conducteur',  'entreprise' => 'Atlas Digital'],
            ['name' => 'Samuel Faure',     'email' => 'samuel.faure@atlasdigital.com',  'ville_residence' => 'Pessac',         'role' => 'passager',    'entreprise' => 'Atlas Digital'],
            ['name' => 'Tina Rousseau',    'email' => 'tina.rousseau@atlasdigital.com', 'ville_residence' => 'Talence',        'role' => 'les_deux',    'entreprise' => 'Atlas Digital'],
            ['name' => 'Ugo Masson',       'email' => 'ugo.masson@atlasdigital.com',    'ville_residence' => 'Bordeaux',       'role' => 'conducteur',  'entreprise' => 'Atlas Digital'],
            ['name' => 'Véra Nicolas',     'email' => 'vera.nicolas@atlasdigital.com',  'ville_residence' => 'Lormont',        'role' => 'passager',    'entreprise' => 'Atlas Digital'],
            ['name' => 'William Guérin',   'email' => 'william.guerin@atlasdigital.com','ville_residence' => 'Bègles',        'role' => 'passager',    'entreprise' => 'Atlas Digital'],
            ['name' => 'Xénia Perrin',     'email' => 'xenia.perrin@atlasdigital.com',  'ville_residence' => 'Pessac',         'role' => 'les_deux',    'entreprise' => 'Atlas Digital'],

            // GreenLogix (8 employés)
            ['name' => 'Yasmine Moreau',   'email' => 'yasmine.moreau@greenlogix.com',  'ville_residence' => 'Nantes',         'role' => 'conducteur',  'entreprise' => 'GreenLogix'],
            ['name' => 'Zacharie Lemaire', 'email' => 'zacharie.lemaire@greenlogix.com','ville_residence' => 'Saint-Herblain', 'role' => 'passager',    'entreprise' => 'GreenLogix'],
            ['name' => 'Ambre Colin',      'email' => 'ambre.colin@greenlogix.com',     'ville_residence' => 'Rezé',           'role' => 'les_deux',    'entreprise' => 'GreenLogix'],
            ['name' => 'Baptiste Marchal', 'email' => 'baptiste.marchal@greenlogix.com','ville_residence' => 'Nantes',         'role' => 'conducteur',  'entreprise' => 'GreenLogix'],
            ['name' => 'Camille Barbier',  'email' => 'camille.barbier@greenlogix.com', 'ville_residence' => 'Orvault',        'role' => 'passager',    'entreprise' => 'GreenLogix'],
            ['name' => 'Dorian Perez',     'email' => 'dorian.perez@greenlogix.com',    'ville_residence' => 'Bouguenais',     'role' => 'les_deux',    'entreprise' => 'GreenLogix'],
            ['name' => 'Elise Roy',        'email' => 'elise.roy@greenlogix.com',       'ville_residence' => 'Carquefou',      'role' => 'passager',    'entreprise' => 'GreenLogix'],
            ['name' => 'Fabien Bertrand',  'email' => 'fabien.bertrand@greenlogix.com', 'ville_residence' => 'Saint-Sébastien','role' => 'conducteur',  'entreprise' => 'GreenLogix'],

            // Kandia Solutions (8 employés)
            ['name' => 'Gina Aubert',      'email' => 'gina.aubert@kandia.com',         'ville_residence' => 'Marseille',      'role' => 'les_deux',    'entreprise' => 'Kandia Solutions'],
            ['name' => 'Hassan Caron',     'email' => 'hassan.caron@kandia.com',        'ville_residence' => 'Aix-en-Provence','role' => 'conducteur',  'entreprise' => 'Kandia Solutions'],
            ['name' => 'Iris Morin',       'email' => 'iris.morin@kandia.com',          'ville_residence' => 'Aubagne',        'role' => 'passager',    'entreprise' => 'Kandia Solutions'],
            ['name' => 'Jordan Dupuis',    'email' => 'jordan.dupuis@kandia.com',       'ville_residence' => 'Marseille',      'role' => 'les_deux',    'entreprise' => 'Kandia Solutions'],
            ['name' => 'Kylian Vasseur',   'email' => 'kylian.vasseur@kandia.com',      'ville_residence' => 'Vitrolles',      'role' => 'conducteur',  'entreprise' => 'Kandia Solutions'],
            ['name' => 'Léa Arnaud',       'email' => 'lea.arnaud@kandia.com',          'ville_residence' => 'Martigues',      'role' => 'passager',    'entreprise' => 'Kandia Solutions'],
            ['name' => 'Mehdi Roger',      'email' => 'mehdi.roger@kandia.com',         'ville_residence' => 'Marseille',      'role' => 'les_deux',    'entreprise' => 'Kandia Solutions'],
            ['name' => 'Nina Schmitt',     'email' => 'nina.schmitt@kandia.com',        'ville_residence' => 'Gardanne',       'role' => 'passager',    'entreprise' => 'Kandia Solutions'],
        ];

        foreach ($employes as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'            => $data['name'],
                    'ville_residence' => $data['ville_residence'],
                    'role'            => $data['role'],
                    'entreprise_id'   => $e[$data['entreprise']],
                    'password'        => Hash::make('password'),
                ]
            );
        }
    }
}
