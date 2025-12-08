<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ReceptionistSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Receptionist 1',
                'email' => 'receptionist1@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 3, // Receptionist
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
