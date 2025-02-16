<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'id_number' => 'required|string|max:50',
            'car_type' => 'required',
            'number_of_passengers' => 'required|integer',
            'car_model' => 'required|string|max:100',
            'car_color' => 'required|string|max:50',
            'licence_plate_number' => 'required|string|max:50',
            'company_name' => 'required|string|max:255',
            'company_registration_number' => 'required|string|max:100',
            'company_type' => 'required|string|max:100',
        ];
    }
}
