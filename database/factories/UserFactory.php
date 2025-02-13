<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
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

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    public function employee(){
        return $this->state(fn(array $attributes) => [
            'role' => 3,
        ]);
    }
}
