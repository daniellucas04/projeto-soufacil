<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecieptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sale_id' => Sale::factory(),
            'price' => fake()->randomFloat(2, 100, 2000),
            'payment_date' => fake()->date('Y-m-d'),
            'status' => fake()->randomElement(['Paid', 'Pending'])
        ];
    }
}
