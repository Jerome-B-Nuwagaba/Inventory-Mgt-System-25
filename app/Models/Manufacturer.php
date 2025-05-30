<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'contact_email',
        'phone',
        // any other relevant fields
    ];

    // Relationships
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function checklists()
    {
        return $this->hasMany(RawMaterialChecklist::class); // if you build a checklist model
    }

    public function producedCars()
    {
        return $this->hasMany(Car::class); // if cars are stored in a `cars` table
    }
}
