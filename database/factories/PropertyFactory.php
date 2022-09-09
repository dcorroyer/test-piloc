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
            'space' => fake()->randomFloat(2, 16, 55),
            'price' => fake()->randomFloat(2, 350, 1000),
            'status' => fake()->randomElement(['available', 'rented', 'deleted'])
        ];
    }
}
