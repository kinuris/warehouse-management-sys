<?php

namespace Database\Factories;

use App\Models\Product;
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
            'internal_id' => 'SBP-' . Product::getNoCollisionID(),
            'name' => fake()->word(),
            'stock_qty' => fake()->numberBetween(0, 100),
            'is_suspended' => false,
            'price' => fake()->numberBetween(100, 1000),
        ];
    }
}
