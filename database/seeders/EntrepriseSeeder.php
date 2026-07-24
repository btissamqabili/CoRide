<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entreprise;

class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        $entreprises = [
            'MobiliTech',
            'NextBuild',
            'Atlas Digital',
            'GreenLogix',
            'Kandia Solutions',
        ];

        foreach ($entreprises as $nom) {
            Entreprise::firstOrCreate(['nom' => $nom]);
        }
    }
}