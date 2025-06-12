<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'capacity',
        'current_utilization',
        'manager_id',
        'status', // active, inactive, maintenance
        'contact_number',
        'address',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'current_utilization' => 'integer',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function getUtilizationPercentage()
    {
        return ($this->current_utilization / $this->capacity) * 100;
    }

    public function hasAvailableSpace()
    {
        return $this->current_utilization < $this->capacity;
    }
} 