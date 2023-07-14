<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $allowableRoleId = UserRole::allRolesExcept(UserRoleEnum::SuperAdmin)
            ->pluck('id');

        return [
            'name' => fake()->name,
            'role_id' => $allowableRoleId->random(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // password
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
