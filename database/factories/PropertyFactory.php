<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wording' => fake()->title,
            'surface' => fake()->randomFloat(2, 16, 55),
            'amount' => fake()->randomFloat(2, 350, 1000),
            'status' => fake()->randomElement(['available', 'rented', 'deleted']),
            'user_id' => rand(1, 10),
            'address_id' => rand(1, 5),
        ];
    }
}
