<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;    
    const TAG = 'inqui';
    const STATUS_PENDING = 'pendi';
    const STATUS_RECEIVED = 'recei';
    const STATUS_INVALID = 'inval';
    const STATUS_LABELS = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_RECEIVED => 'Received',
        self::STATUS_INVALID => 'Invalid',
    ];
    const PERMISSION_VIEW = 'view';
    const PERMISSION_RECEIVE = 'recei';
    const PERMISSION_INVALID = 'inval';
    protected $fillable = [
        'itemType_id',
        'cargoType_id',
        'email',
        'contactNumber',
        'referenceNumber',
        'quantity',
        'deliveryType',
        'status',
        'targetDate',
    ];
    
    public function cargoType() {
        return $this->belongsTo(CargoType::class,'cargoType_id');
    }

    public function itemType() {
        return $this->belongsTo(ItemType::class,'itemType_id');
    }
}
