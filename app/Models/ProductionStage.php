<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionStage extends Model
{
    use HasFactory;

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
