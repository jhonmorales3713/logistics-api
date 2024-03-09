<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VehicleModel;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/data/vehicleModel.json");
        $models = json_decode($json);
        foreach ($models as $key => $value) {
            VehicleModel::create([
                "name" => $value->name,
                "status" => $value->status,
            ]);
        }
    }
}
