<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passengers extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'name', 'nationality', 'mobile_number','id_number'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
