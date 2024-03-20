<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentRequest extends Model
{
    use HasFactory;
    const TAG = 'shReq';
    const STATUS_PENDING = 'pendi';
    const STATUS_APPROVE = 'appro';
    const STATUS_DECLINE = 'decli';
    const STATUS_LABELS = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVE => 'Approve',
        self::STATUS_DECLINE => 'Decline',
    ];
    const PERMISSION_VIEW = 'view';
    const PERMISSION_UPDATE = 'updat';
    const PERMISSION_APPROVE = 'appro';

    protected $fillable = [
        'inquiry_id',
        'vehicle_id',
        'consignee_id',
        'estimatedDeliveryDate',
        'origin',
        'destination',
        'status',
    ];
    public function inquiry() {
        return $this->belongsTo(Inquiry::class,'inquiry_id');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }

    public function consignee() {
        return $this->belongsTo(Consignee::class,'consignee_id');
    }

    public function shipmentRequestItems() {
        return $this->hasMany(ShipmentRequestItem::class);
    }
}
