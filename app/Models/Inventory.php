<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'item_type',
        'item_id',
        'quantity',
        'location',
        'condition', // new, used, damaged
        'last_checked_at',
        'minimum_stock_level',
        'maximum_stock_level',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'last_checked_at' => 'datetime',
        'minimum_stock_level' => 'integer',
        'maximum_stock_level' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'item_id')->where('item_type', 'raw_material');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'item_id')->where('item_type', 'car');
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->minimum_stock_level;
    }

    public function isOverstocked()
    {
        return $this->quantity >= $this->maximum_stock_level;
    }
}
