<?php

namespace Database\Factories;

use App\Models\StockMatiere;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockMatiereFactory extends Factory
{
    protected $model = StockMatiere::class;

    public function definition(): array
    {
        $quantity = fake()->randomFloat(2, 80, 250);

        return [
            'date_achat' => fake()->dateTimeBetween('-45 days', 'today'),
            'quantite_kg' => $quantity,
            'cout_total' => round($quantity * fake()->randomFloat(2, 120, 170), 2),
            'fournisseur' => fake()->randomElement([
                'Cooperative Manioc Maritime',
                'AgriTogo Bio',
                'Groupement Femmes de Tsevie',
                'Union des Producteurs de Kpalime',
            ]),
        ];
    }
}
