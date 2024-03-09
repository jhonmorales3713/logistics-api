<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoType extends Model
{
    use HasFactory;
    
    public function inquiries() {
        return $this->hasMany(Inquiry::class);
    }
    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }
}
