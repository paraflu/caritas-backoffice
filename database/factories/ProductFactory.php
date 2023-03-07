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
     * 
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'price' => $this->faker->randomNumber(3),
        ];
    }
}