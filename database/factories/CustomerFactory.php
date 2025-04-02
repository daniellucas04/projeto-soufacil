<?php

namespace Database\Factories;

use Avlima\PhpCpfCnpjGenerator\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'cpf_cnpj' => $this->generateCpfCnpj(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
        ];
    }

    private function generateCpfCnpj()
    {
        return rand(0, 1) ? Generator::cpf(true) : Generator::cnpj(true);
    }
}
