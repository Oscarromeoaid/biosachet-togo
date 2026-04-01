<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->company(),
            'telephone' => fake()->numerify('9#######'),
            'email' => fake()->optional()->companyEmail(),
            'type' => fake()->randomElement(Client::TYPES),
            'ville' => fake()->randomElement(['Lome', 'Kara', 'Sokode', 'Atakpame', 'Tsevie']),
        ];
    }
}
