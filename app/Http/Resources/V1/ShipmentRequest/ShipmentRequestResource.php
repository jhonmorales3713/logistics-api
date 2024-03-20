<?php

namespace App\Http\Resources\V1\ShipmentRequest;

use Illuminate\Http\Request;
use App\Models\ShipmentRequest;
use App\Http\Resources\V1\Inquiry\InquiryFragment;
use App\Http\Resources\V1\Vehicle\VehicleFragment;
use App\Http\Resources\V1\Consignee\ConsigneeFragment;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentRequestResource extends JsonResource
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
            'deliveryDate' => $this->estimatedDeliveryDate,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'inquiry' => new InquiryFragment($this->whenLoaded('inquiry')),
            'consignee' => new ConsigneeFragment($this->whenLoaded('consignee')),
            'vehicle' => new VehicleFragment($this->whenLoaded('vehicle')),
            'items' => ShipmentRequestItemCollection::collection($this->whenLoaded('shipmentRequestItems')),
            'canApprove' => $this->status == ShipmentRequest::STATUS_PENDING,
            'canUnapprove' => $this->status == ShipmentRequest::STATUS_APPROVE,
            'canDecline' => $this->status == ShipmentRequest::STATUS_PENDING,
            'createdAt' => $this->created_at,
            'status' => $this->status,
        ];
    }
}
