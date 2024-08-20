<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GasQualitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gas_qualities')->insert([
            ['name' => 'A', 'price' => 1.80],
            ['name' => 'B', 'price' => 1.70],
            ['name' => 'C', 'price' => 1.90],
            ['name' => 'D', 'price' => 1.50],
            ['name' => 'E', 'price' => 1.75],
        ]);
    }
}
