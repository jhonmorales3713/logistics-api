<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([CargoTypeSeeder::class]);
        $this->call([ItemTypeSeeder::class]);
        $this->call([InquirySeeder::class]);
        $this->call([VehicleMakeSeeder::class]);
        $this->call([GasTypeSeeder::class]);
        $this->call([VehicleModelSeeder::class]);
        $this->call([VehicleSeeder::class]);
        $this->call([UserRolesSeeder::class]);
        $this->call([ConsigneeSeeder::class]);
        $this->call([ShipmentRequestSeeder::class]);
        $this->call([ShipmentRequestItemSeeder::class]);
    }
}
