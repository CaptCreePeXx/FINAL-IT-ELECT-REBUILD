<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed roles first
        $this->call(RolesTableSeeder::class);

        // Seed users by role
        $this->call([
            AdminUserSeeder::class,
            DentistSeeder::class,
            ReceptionistSeeder::class,
            PatientSeeder::class,
        ]);

        // Seed services
        $this->call(ServicesSeeder::class);
    }
}
