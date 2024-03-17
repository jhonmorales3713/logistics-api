<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\ShipmentRequestItem;
use Illuminate\Support\Facades\File;

class ShipmentRequestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $json = File::get("database/data/shipmentRequestItem.json");
        $shipmentRequestItem = json_decode($json);
        foreach ($shipmentRequestItem as $key => $value) {
            ShipmentRequestItem::create([
                "shipment_request_id" => $value->shipmentRequest_id,
                "quantity" => $value->quantity,
                "name" => $value->name,
            ]);
        };
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
