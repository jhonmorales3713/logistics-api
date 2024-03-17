<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\ShipmentRequest;
use Illuminate\Support\Facades\File;

class ShipmentRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $json = File::get("database/data/shipmentRequest.json");
        $shipmentRequest = json_decode($json);
        foreach ($shipmentRequest as $key => $value) {
            ShipmentRequest::create([
                "inquiry_id" => $value->inquiry_id,
                "vehicle_id" => $value->vehicle_id,
                "consignee_id" => $value->consignee_id,
                "status" => $value->status,
                "estimatedDeliveryDate" => $value->estimatedDeliveryDate,
                "destination" => $value->destination,
                "origin" => $value->origin,
            ]);
        };
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
