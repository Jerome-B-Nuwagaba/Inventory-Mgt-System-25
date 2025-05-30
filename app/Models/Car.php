<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }

    public function productionStage()
    {
        return $this->hasOne(ProductionStage::class);
    }

    public function inventoryItem()
    {
        return $this->hasOne(InventoryItem::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}
