<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
