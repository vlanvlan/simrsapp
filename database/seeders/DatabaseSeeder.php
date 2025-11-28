<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders first (to create dependencies)
        $this->call([
            // Add other seeder classes here if needed
            // UnitsSeeder::class,
            // PositionsSeeder::class,
            // EmployeesSeeder::class,
        ]);

        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@simrsapp.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'employee_id' => null,
        ]);

        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@simrsapp.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'active',
            'employee_id' => null,
        ]);

        // Create additional users using factory
        User::factory(5)->create();
    }
}
