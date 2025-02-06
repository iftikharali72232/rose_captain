<?php
// Vehicle.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['user_id', 'car_type', 'number_of_passengers', 'car_model', 'car_color', 'licence_plate_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
