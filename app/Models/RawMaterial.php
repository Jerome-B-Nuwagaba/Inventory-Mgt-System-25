<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RawMaterial extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
