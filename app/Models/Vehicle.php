<?php
// Vehicle.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Vehicle extends Model
{
    protected $fillable = ['user_id', 'car_type', 'number_of_passengers', 'car_model', 'car_color', 'licence_plate_number', 'car_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['car_image_url'];

    public function getCarImageUrlAttribute()
    {
        if (!$this->car_image) return null;
        
        // // Use either:
        // return asset("storage/{$this->car_image}");
        
        // OR
        return Storage::disk('public')->url($this->car_image);
    }
}
