<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignee extends Model
{
    use HasFactory;

    public function shipmentRequests() {
        return $this->hasMany(ShipmentRequest::class);
    }
}
