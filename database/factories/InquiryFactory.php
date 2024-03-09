<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\ItemType;
use App\Models\CargoType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $referenceNumber = strtolower(str_replace(' ', '', $this->faker->name()));
        return [
            'email' => $this->faker->email(),
            'contactNumber' => '09'.rand(100000000,999999999),
            'itemType_id' => DB::table('item_types')->pluck('id')->random(),
            'cargoType_id' => DB::table('cargo_types')->pluck('id')->random(),
            'referenceNumber' => $referenceNumber,
            'quantity' => rand(1,1000),
            'deliveryType' => $this->faker->randomElement(['prelo','load']),
            'status'=>'pendi',
            'targetDate' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
        ];
    }
}
