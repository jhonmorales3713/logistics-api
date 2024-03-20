<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentRequestItem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'shipment_request_id',
        'name',
        'quantity'
    ];

    public function shipmentRequest() {
        return $this->belongsTo(ShipmentRequest::class);
    }
}
