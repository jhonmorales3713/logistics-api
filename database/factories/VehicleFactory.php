<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\VehicleMake;
use Illuminate\Support\Facades\DB;
use App\Models\CargoType;
use App\Models\GasType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomDate = $this->faker->dateTime();
        return [
            'plateNumber' => $this->generateRandom(6, 'plateNumber'),
            'year' => rand(1960,2023),
            'color' => $this->faker->randomElement(['Green','Blue','Black','Red','Yellow','Gray','Orange','White','Violet']),
            'transmission' => $this->faker->randomElement([Vehicle::TRANSMISSION_MANUAL,Vehicle::TRANSMISSION_AUTOMATIC]),
            'chassisNumber' => $this->generateRandom(13, 'chassisNumber'),
            'vin' => $this->generateRandom(13, 'vin'),
            'price' => rand(100000,2000000),
            'mileAge' => rand(10,100000),
            'status'=> $this->faker->randomElement([Vehicle::STATUS_ACTIVE,Vehicle::STATUS_FOR_MAINTENNANCE,Vehicle::STATUS_ON_MAINTENNANCE]),
            'registryExpiration' => $randomDate->format('Y-m-d H:i:s'),
            'registryDate' => date_sub($randomDate, date_interval_create_from_date_string('10 days'))->format('Y-m-d H:i:s'),
            'lastMaintennanceDate' => date_sub($randomDate, date_interval_create_from_date_string('20 days'))->format('Y-m-d H:i:s'),
            'maxLoad' => rand(1000,20000),
            'wheelCount' => $this->faker->randomElement([4, 6, 8, 10, 12]),
            'model_id' => DB::table('vehicle_models')->pluck('id')->random(),
            'make_id' => DB::table('vehicle_makes')->pluck('id')->random(),
            'type_id' => DB::table('cargo_types')->pluck('id')->random(),
            'gasType_id' => DB::table('gas_types')->pluck('id')->random(),
        ];
    }
    protected function generateRandom($max, $column) {
        $refNum = ['A', 'B', 'C', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'
            , 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '1'
            , '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $refNumStr = '';
        do {
            $refNumStr .= $refNum[rand(0, count($refNum) - 1)];
        } while (strlen($refNumStr) < $max);
            $result = Vehicle::where($column, $refNumStr)->first();
        if (!$result) {
            return $refNumStr;
        } else {
            $this->generateReferenceNumber();
        }
    }
}
