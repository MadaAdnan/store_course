<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'info' => fake()->text,
            'price' => fake()->randomFloat(2, 5, 100),
            'status' => fake()->randomElement(['available', 'unavailable', 'inactive']),
            'user_id' => 3,
            'category_id' => fake()->numberBetween(1, 5),
        ];
    }
}
