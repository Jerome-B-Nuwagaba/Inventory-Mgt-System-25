<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
