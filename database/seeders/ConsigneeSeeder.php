<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Consignee;

class ConsigneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Consignee::factory()
        ->create(['name'=>'Consignee 1', 'position' => 'Manager', 'status'=>'activ']);
        Consignee::factory()
        ->create(['name'=>'Consignee 2', 'position' => 'Director', 'status'=>'activ']);
    }
}
