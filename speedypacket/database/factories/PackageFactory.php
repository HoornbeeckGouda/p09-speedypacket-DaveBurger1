<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'recipient_name' => fake('nl_NL')->name(),
            'recipient_email' => fake()->email(),
            'recipient_phone' => fake()->phoneNumber(),
            'recipient_address' => fake('nl_NL')->address(),
            'description' => fake()->sentence(),
            'weight' => fake()->randomFloat(2, 0.1, 10),
            'status' => fake()->randomElement(['pending', 'in_transit', 'delivered']),
            'tracking_number' => fake()->unique()->regexify('[A-Z]{2}[0-9]{8}'),
        ];
    }

    /**
     * Indicate that the package is in transit.
     */
    public function inTransit(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_transit',
        ]);
    }
}
