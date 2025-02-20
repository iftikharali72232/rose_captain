<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subscription_type',
        'from_date',
        'to_date',
        'amount'
    ];

    // Check if subscription is active
    public function isActive()
    {
        return now()->between($this->from_date, $this->to_date);
    }

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
