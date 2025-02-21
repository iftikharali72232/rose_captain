<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreFormRequest extends FormRequest
{
    public function rules()
    {
        $driver = User::where('mobile', $this->input('mobile'))->where('user_type', 1)->where('name','guest')->first();
        if (!$driver):
        return [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15|unique:users,mobile',
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
        else:
            return  [];
        endif;
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'mobile.required' => 'The mobile number field is required.',
            'mobile.unique' => 'This mobile number is already registered.',
            'mobile.max' => 'The mobile number must not exceed 15 characters.',
            'id_number.required' => 'The ID number field is required.',
            'car_type.required' => 'The car type field is required.',
            'number_of_passengers.required' => 'The number of passengers field is required.',
            'number_of_passengers.integer' => 'The number of passengers must be a number.',
            'number_of_passengers.min' => 'At least one passenger is required.',
            'car_model.required' => 'The car model field is required.',
            'car_color.required' => 'The car color field is required.',
            'licence_plate_number.required' => 'The license plate number field is required.',
            'company_name.required' => 'The company name field is required.',
            'company_registration_number.required' => 'The company registration number field is required.',
            'company_type.required' => 'The company type field is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
