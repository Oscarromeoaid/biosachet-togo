<?php

namespace Database\Factories;

use App\Models\MessageContact;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageContactFactory extends Factory
{
    protected $model = MessageContact::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->name(),
            'telephone' => fake()->numerify('9#######'),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraph(),
            'traite_le' => fake()->optional()->dateTimeBetween('-5 days', 'now'),
        ];
    }
}
