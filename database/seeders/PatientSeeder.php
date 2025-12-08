<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Patient 1',
                'email' => 'patient1@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Patient
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Patient 2',
                'email' => 'patient2@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Patient
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
