<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionBatch extends Model
{
    use HasFactory;

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
