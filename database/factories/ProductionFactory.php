<?php

namespace Database\Factories;

use App\Models\Production;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionFactory extends Factory
{
    protected $model = Production::class;

    public function definition(): array
    {
        return [
            'date' => fake()->unique()->dateTimeBetween('-30 days', 'today'),
            'kg_manioc_utilise' => fake()->randomFloat(2, 12, 34),
            'sachets_petit_transparent' => fake()->numberBetween(110, 240),
            'sachets_moyen_souple' => fake()->numberBetween(90, 180),
            'sachets_grand_solide' => fake()->numberBetween(30, 85),
            'film_biodegradable_m2' => fake()->randomFloat(2, 6, 28),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
