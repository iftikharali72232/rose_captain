<?php


// Company.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['user_id', 'company_name', 'company_registration_number', 'company_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
