<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_focus',
        'status',
        'throughput',
        'product_id',
        'retailer_order_id',
        'current_stage',
        'failed_reason',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function retailerOrder()
    {
        return $this->belongsTo(RetailerOrder::class);
    }
}