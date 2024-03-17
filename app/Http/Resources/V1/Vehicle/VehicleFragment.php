<?php

namespace App\Http\Resources\V1\Vehicle;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Http\Resources\V1\VehicleModelResource;
use App\Http\Resources\V1\VehicleMakeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleFragment extends JsonResource
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
            'model' => new VehicleModelResource($this->whenLoaded('vehicleModel')),
            'make' => new VehicleMakeResource($this->whenLoaded('vehicleMake')),
            'plateNumber' => $this->plateNumber,
        ];
    }
}
