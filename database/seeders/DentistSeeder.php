<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DentistSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Dr. John Doe',
                'email' => 'dentist1@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Dentist
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Jane Smith',
                'email' => 'dentist2@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Dentist
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
