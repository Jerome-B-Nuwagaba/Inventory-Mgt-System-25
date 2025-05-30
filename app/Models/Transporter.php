<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transporter extends Model
{
    use HasFactory;

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
