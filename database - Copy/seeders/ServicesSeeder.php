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
                'description' => 'Routine cleaning to remove plaque and tartar.',
                'price' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tooth Extraction',
                'description' => 'Removal of decayed or problematic teeth.',
                'price' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dental Filling',
                'description' => 'Restoration of cavities with composite material.',
                'price' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
