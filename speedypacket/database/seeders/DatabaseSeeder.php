<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create at least one user for each role using faker
        User::factory()->create(['role' => 'verzender']);
        User::factory()->create(['role' => 'ontvanger']);
        User::factory()->create(['role' => 'koerier']);
        User::factory()->create(['role' => 'magazijn']);
        User::factory()->create(['role' => 'backoffice']);
        User::factory()->create(['role' => 'directie']);

        // Create some additional random users
        User::factory()->count(5)->create();
    }
}
