<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suppliers extends Model
{
       use HasFactory;

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }

}
