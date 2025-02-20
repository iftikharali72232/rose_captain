<?php


// Company.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }


    protected $fillable = ['user_id', 'company_name', 'company_registration_number', 'company_type', 'company_location', 'license_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
