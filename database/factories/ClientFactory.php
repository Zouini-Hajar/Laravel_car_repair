<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'cin' => fake()->unique()->regexify('[A-Z][0-9]{6}'),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'user_id' => fake()->numberBetween(1, 10)
        ];
    }
}
