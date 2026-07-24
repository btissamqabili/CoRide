<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entreprise;

class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        Entreprise::create([
            'nom' => 'MobiliTech',
            'email' => 'contact@mobilitech.com',
        ]);

        Entreprise::create([
            'nom' => 'TechCorp',
            'email' => 'contact@techcorp.com',
        ]);

        Entreprise::create([
            'nom' => 'Digital Solutions',
            'email' => 'contact@digitalsolutions.com',
        ]);
    }
}