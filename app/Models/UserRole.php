<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    const TAG = 'vehic';
    const STATUS_ACTIVE = 'activ';
    const STATUS_INACTIVE = 'inact';
    const STATUS_LABELS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];
    public function users() {
        return $this->hasMany(User::class);
    }
    public function createdBy() {
        return $this->belongsTo(User::class,'created_by');
    }
    protected $fillable = [
        'name',
        'access',
        'status',
        'updated_at',
    ];
}
