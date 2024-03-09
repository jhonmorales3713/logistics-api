<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\GasType;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class GasTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/data/gasType.json");
        $gasTypes = json_decode($json);
        foreach ($gasTypes as $key => $value) {
            GasType::create([
                "name" => $value->name,
                "status" => $value->status,
            ]);
        }
    }
}
