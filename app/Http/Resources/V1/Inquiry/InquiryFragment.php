<?php

namespace App\Http\Resources\V1\Inquiry;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Http\Resources\V1\ItemTypeResource;
use App\Http\Resources\V1\CargoTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InquiryFragment extends JsonResource
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
            'referenceNumber' => $this->referenceNumber,
            'deliveryType' => $this->deliveryType,
            'itemType' => new ItemTypeResource($this->whenLoaded('itemType')),
            'cargoType' => new CargoTypeResource($this->whenLoaded('cargoType')),
            'quantity' => $this->quantity,
        ];
    }
}
