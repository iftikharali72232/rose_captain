<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'passenger_qty','user_id'];

    public function passengers()
    {
        return $this->hasMany(Passengers::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
