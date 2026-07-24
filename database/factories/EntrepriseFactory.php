<?php

namespace Database\Factories;

use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntrepriseFactory extends Factory
{
    protected $model = Entreprise::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->company(),
        ];
    }
}
