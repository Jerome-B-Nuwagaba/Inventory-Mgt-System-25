<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guard = 'supplier';
    protected $fillable = [
        'user_id',
        'company_name',
        'plant_location',
        'production_units',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}