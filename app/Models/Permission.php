<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    const PERMISSIONS_INQUIRY = ['view','recei','inval'];
    const INQUIRY_MODEL = Inquiry::TAG;
    const PERMISSIONS_VEHICLE = ['creat','updat','forMa','onMai'];
    const VEHICLE_MODEL = Vehicle::TAG;
    const PERMISSIONS = [
        self::INQUIRY_MODEL => self::PERMISSIONS_INQUIRY,
        self::VEHICLE_MODEL => self::PERMISSIONS_VEHICLE,
    ];
}
