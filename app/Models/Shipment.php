<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    public function transporter()
    {
        return $this->belongsTo(Transporter::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
