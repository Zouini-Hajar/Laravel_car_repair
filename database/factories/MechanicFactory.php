<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mechanic>
 */
class MechanicFactory extends Factory
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
            'recruitment_date' => fake()->date(),
            'salary' => fake()->numberBetween(2500, 4000),
            'user_id' => fake()->numberBetween(11, 20)
        ];
    }
}
