<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Http\Resources\Json\JsonResource;

class InquiryResource extends JsonResource
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
            'itemType' => new ItemTypeResource($this->whenLoaded('itemType')),
            'email' => $this->email,
            'contactNumber' => $this->contactNumber,
            'cargoType' => new CargoTypeResource($this->whenLoaded('cargoType')),
            'status' => $this->status,
            'quantity' => $this->quantity,
            'referenceNumber' => $this->referenceNumber,
            'targetDate' => $this->targetDate,
            'createdAt' => $this->created_at,
            'receivedAt' => $this->received_at,
            'canReceive' => $this->status == Inquiry::STATUS_PENDING,
            'canInvalid' => $this->status == Inquiry::STATUS_PENDING || $this->status == Inquiry::STATUS_RECEIVED,
        ];
    }
}
