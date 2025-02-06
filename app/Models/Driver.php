<?php

// User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['name', 'mobile', 'id_number', 'user_type'];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
