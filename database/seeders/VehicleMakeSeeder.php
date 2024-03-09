<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VehicleMake;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class VehicleMakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/data/vehicleMaker.json");
        $makers = json_decode($json);
        foreach ($makers as $key => $value) {
            VehicleMake::create([
                "name" => $value->name,
                "status" => $value->status,
            ]);
        }
    }
}
