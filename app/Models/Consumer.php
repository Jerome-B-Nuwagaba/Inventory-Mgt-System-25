<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Consumer extends Authenticatable
{
    protected $guard = 'supplier';
    protected $fillable = ['name', 'email', 'password'];
}
