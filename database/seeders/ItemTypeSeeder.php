<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ItemType;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemType::factory()
        ->create(['name'=>'Goods', 'status' => 'activ']);
        ItemType::factory()
        ->create(['name'=>'Furniture', 'status' => 'activ']);
    }
}
