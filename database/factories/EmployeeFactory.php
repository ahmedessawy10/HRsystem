<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->fake()->time();
        $end = $start + 8;
        $gender = $this->fake()->randomElement(['male', 'female']);

        return [
            'name' => $this->fake()->name($gender),
            'email' => $this->fake()->unique()->safeEmail(),
            'password' => Hash::make('123456'),
            'phone' => $this->fake()->phoneNumber(),
            'address' => $this->fake()->address(),
            'role' => 3,
            'status' => $this->fake()->randomElement(['active', 'inactive', 'pending', 'leave']),
            'join_date' => $this->fake()->date(),
            'start_time' => $start,
            'end_time' => $end,
            'salary' => $this->fake()->numberBetween(10000, 50000),
            'gender' => $gender,
        ];
    }
}
