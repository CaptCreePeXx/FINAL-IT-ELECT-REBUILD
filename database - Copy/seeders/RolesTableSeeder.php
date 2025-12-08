<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Remove all roles safely without FK issues
        DB::table('roles')->delete();

        // Insert default roles
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Patient'],
            ['id' => 2, 'name' => 'Dentist'],
            ['id' => 3, 'name' => 'Receptionist'],
            ['id' => 4, 'name' => 'Admin'],
        ]);
    }
}
