<?php

namespace App\Http\Resources\V1\Consignee;

use Illuminate\Http\Request;
use App\Models\Consignee;
use App\Http\Resources\V1\ItemTypeResource;
use App\Http\Resources\V1\CargoTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsigneeFragment extends JsonResource
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
            'name' => $this->name,
            'position' => $this->position,
        ];
    }
}
