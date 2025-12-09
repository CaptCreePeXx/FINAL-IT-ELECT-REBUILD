<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'name' => 'Teeth Cleaning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tooth Extraction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dental Filling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
