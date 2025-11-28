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
            'recipient_name' => 'John Doe',
            'recipient_email' => 'john@example.com',
            'recipient_phone' => '123-456-7890',
            'recipient_address' => '123 Main St, Anytown, NL',
            'description' => 'Sample package',
            'weight' => 1.5,
            'status' => 'pending',
            'tracking_number' => 'AB12345678',
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
