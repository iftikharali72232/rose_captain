<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverCard extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_number', 'mobile', 'image','user_id'];

}
