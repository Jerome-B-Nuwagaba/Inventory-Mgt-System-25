<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function manufacturer()
{
    return $this->belongsTo(Manufacturer::class);
}

}
