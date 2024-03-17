<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentRequestItem extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function shipmentRequest() {
        return $this->belongsTo(ShipmentRequest::class,'shipment_request_id');
    }
}
