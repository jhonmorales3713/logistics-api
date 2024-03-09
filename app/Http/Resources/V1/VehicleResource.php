<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // dd ($this);
        return [
            'id' => $this->id,
            'plateNumber' => $this->plateNumber,
            'year' => $this->year,
            'color' => $this->color,
            'vin' => $this->vin,
            'transmission' => $this->transmission,
            'chassisNumber' => $this->chassisNumber,
            'registryExpiration' => $this->registryExpiration,
            'registryDate' => $this->registryDate,
            'lastMaintennanceDate' => $this->lastMaintennanceDate,
            'maxLoad' => $this->maxLoad,
            'price' => $this->price,
            'mileAge' => $this->mileAge,
            'status' => $this->status,
            'wheelCount' => $this->wheelCount,
            'type' => new CargoTypeResource($this->whenLoaded('type')),
            'vehicleModel' => new VehicleModelResource($this->whenLoaded('vehicleModel')),
            'vehicleMake' => new VehicleMakeResource($this->whenLoaded('vehicleMake')),
            'gasType' => new GasTypeResource($this->whenLoaded('gasType')),
            'createdAt' => $this->created_at,
            'canActive' => $this->status == Vehicle::STATUS_ON_MAINTENNANCE,
            'canOnMaintennance' => $this->status == Vehicle::STATUS_FOR_MAINTENNANCE,
            'canForMaintennance' => $this->status == Vehicle::STATUS_ACTIVE,
        ];
    }
}
