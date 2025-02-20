<?php

// User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['name', 'mobile', 'id_number', 'user_type', 'status'];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'user_id', 'id');
    }


    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
