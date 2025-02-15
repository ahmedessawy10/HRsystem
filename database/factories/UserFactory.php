<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $startTime = $this->faker->time('H:i:s');
        $endTime = date('H:i:s', strtotime($startTime) + (8 * 3600)); // إضافة 8 ساعات

        $gender = $this->faker->randomElement(['male', 'female']);
        $department = $this->faker->randomElement(Department::pluck('id'));

        return [
            'name' => $this->faker->name($gender),
            'fullname' => $this->faker->name($gender),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            // 'status' => $this->faker->randomElement(['active', 'inactive', 'pending', 'leave']),
            'status' => 'active',
            'department_id' =>$department,
            'join_date' => $this->faker->date(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'salary' => $this->faker->numberBetween(10000, 50000),
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


    public function employee(): static
    {
        return $this->afterCreating(function (User $user) {
            $role = Role::firstOrCreate(['name' => 'employee']);
            $user->assignRole($role);
        });
    }
}
