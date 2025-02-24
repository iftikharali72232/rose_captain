<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreFormRequest extends FormRequest
{
    public function rules()
    {
        $driver = User::where('mobile', $this->input('mobile'))->where('user_type', 1)->where('name','guest')->first();
        if (!$driver):
        return [
            'name' => 'required|string|max:255',
            'mobile' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users', 'mobile')->where(function ($query) {
                    return $query->where('user_type', 1);
                }),
            ],
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
        $lang = request()->lang === 'ar'; // Check if the language is Arabic

        return [
            'name.required' => $lang ? 'حقل الاسم مطلوب.' : 'The name field is required.',
            'mobile.required' => $lang ? 'حقل رقم الجوال مطلوب.' : 'The mobile number field is required.',
            'mobile.unique' => $lang ? 'رقم الجوال مسجل بالفعل.' : 'This mobile number is already registered.',
            'mobile.max' => $lang ? 'يجب ألا يتجاوز رقم الجوال 15 حرفًا.' : 'The mobile number must not exceed 15 characters.',
            'id_number.required' => $lang ? 'حقل رقم الهوية مطلوب.' : 'The ID number field is required.',
            'car_type.required' => $lang ? 'حقل نوع السيارة مطلوب.' : 'The car type field is required.',
            'number_of_passengers.required' => $lang ? 'حقل عدد الركاب مطلوب.' : 'The number of passengers field is required.',
            'number_of_passengers.integer' => $lang ? 'يجب أن يكون عدد الركاب رقمًا.' : 'The number of passengers must be a number.',
            'number_of_passengers.min' => $lang ? 'مطلوب راكب واحد على الأقل.' : 'At least one passenger is required.',
            'car_model.required' => $lang ? 'حقل طراز السيارة مطلوب.' : 'The car model field is required.',
            'car_color.required' => $lang ? 'حقل لون السيارة مطلوب.' : 'The car color field is required.',
            'licence_plate_number.required' => $lang ? 'حقل رقم لوحة السيارة مطلوب.' : 'The license plate number field is required.',
            'company_name.required' => $lang ? 'حقل اسم الشركة مطلوب.' : 'The company name field is required.',
            'company_registration_number.required' => $lang ? 'حقل رقم تسجيل الشركة مطلوب.' : 'The company registration number field is required.',
            'company_type.required' => $lang ? 'حقل نوع الشركة مطلوب.' : 'The company type field is required.',
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
