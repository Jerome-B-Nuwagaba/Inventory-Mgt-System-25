<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLPrediction extends Model
{
    use HasFactory;

    protected $table = 'ml_predictions';

    protected $fillable = [
        'region',
        'car_id',
        'predicted_demand',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
} 