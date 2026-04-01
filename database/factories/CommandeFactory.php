<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeFactory extends Factory
{
    protected $model = Commande::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'total' => fake()->randomFloat(2, 2000, 40000),
            'statut' => fake()->randomElement(Commande::STATUTS),
            'paiement' => fake()->randomElement(Commande::PAIEMENTS),
            'methode_paiement' => fake()->randomElement(Commande::METHODES_PAIEMENT),
            'date_livraison' => fake()->optional()->dateTimeBetween('-15 days', '+7 days'),
        ];
    }
}
