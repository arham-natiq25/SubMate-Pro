<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'id' => Str::uuid(),
                'name' => 'Basic',
                'short_description' => 'Basic plan description',
                'monthly_price' => 9.99,
                'year_price' => 99.99,
                'trial' => 1, // Change to 0 if you don't want a trial for the basic plan
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Premium',
                'short_description' => 'Premium plan description',
                'monthly_price' => 19.99,
                'year_price' => 199.99,
                'trial' => 1, // Change to 0 if you don't want a trial for the premium plan
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert plans into the database
        DB::table('plans')->insert($plans);
    }
}
