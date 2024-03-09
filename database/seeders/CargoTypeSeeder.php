<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CargoType;

class CargoTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CargoType::factory()
        ->create(['name'=>'Van', 'status' => 'activ']);
        CargoType::factory()
        ->create(['name'=>'Closed Van', 'status' => 'activ']);
    }
}
