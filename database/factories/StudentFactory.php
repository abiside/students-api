<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_id' => fake()->unique()->numberBetween(1600000000000,1699999999999),
            'name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
