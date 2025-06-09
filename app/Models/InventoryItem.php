<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'category',
        'location',
        'current_stock',
        'max_stock',
        'min_stock_threshold',
        'critical_stock_threshold',
        'unit_price',
    ];
}
