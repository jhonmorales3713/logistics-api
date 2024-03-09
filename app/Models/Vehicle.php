<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    const TAG = 'vehic';
    const STATUS_ACTIVE = 'activ';
    const STATUS_ON_MAINTENNANCE = 'onMai';
    const STATUS_FOR_MAINTENNANCE = 'forMa';
    const STATUS_LABELS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_ON_MAINTENNANCE => 'On Maintennance',
        self::STATUS_FOR_MAINTENNANCE => 'For Maintennance',
    ];
    const TRANSMISSION_MANUAL = 'manua';
    const TRANSMISSION_AUTOMATIC = 'autom';
    const TRANSMISSION_LABELS = [
        self::TRANSMISSION_MANUAL => 'Manual',
        self::TRANSMISSION_AUTOMATIC => 'Automatic',
    ];
    protected $fillable = [
        'make_id',
        'type_id',
        'gasType_id',
        'model_id',
        'vin',
        'price',
        'mileAge',
        'plateNumber',
        'year',
        'color',
        'chassisNumber',
        'transmission',
        'status',
        'registryExpiration',
        'registryDate',
        'lastMaintennanceDate',
        'maxLoad',
        'wheelCount',
        'status',
    ];
    
    public function type() {
        return $this->belongsTo(CargoType::class,'type_id');
    }

    public function vehicleMake() {
        return $this->belongsTo(VehicleMake::class,'make_id');
    }

    public function gasType() {
        return $this->belongsTo(GasType::class,'gasType_id');
    }

    public function vehicleModel() {
        return $this->belongsTo(VehicleModel::class,'model_id');
    }
}
