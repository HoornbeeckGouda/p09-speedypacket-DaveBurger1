<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a set of specific-role users useful for development / testing
        User::factory()->create([
            'name' => 'Directie Admin',
            'username' => 'directie',
            'email' => 'directie@example.com',
            'role' => 'directie',
        ]);

        User::factory()->create([
            'name' => 'Backoffice User',
            'username' => 'backoffice',
            'email' => 'backoffice@example.com',
            'role' => 'backoffice',
        ]);

        User::factory()->create([
            'name' => 'Magazijn Medewerker',
            'username' => 'magazijn1',
            'email' => 'magazijn@example.com',
            'role' => 'magazijn',
        ]);

        User::factory()->create([
            'name' => 'Koerier Demo',
            'username' => 'koerier1',
            'email' => 'koerier@example.com',
            'role' => 'koerier',
        ]);

        User::factory()->create([
            'name' => 'Verzender Demo',
            'username' => 'verzender1',
            'email' => 'verzender@example.com',
            'role' => 'verzender',
        ]);

        User::factory()->create([
            'name' => 'Ontvanger Demo',
            'username' => 'ontvanger1',
            'email' => 'ontvanger@example.com',
            'role' => 'ontvanger',
        ]);

        // Create some additional random users
        User::factory()->count(8)->create();
    }
}
