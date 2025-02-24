<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        public function store(Request $request)
    {

        $user = User::where('mobile', $request->mobile)->where('user_type', 2)->where('name', 'guest@')->first();

        if ($user):
            $user->update([
                'mobile' => 'guest@',
                'id_number' => 'guest@'
            ]);
        endif;
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users', 'mobile')->where(function ($query) {
                    return $query->where('user_type', 2);
                }),
            ],
            'gender' => 'required',
            'city' => 'required|string|max:100',
        ],[
            'name.required' => $request->lang === 'ar' ? 'حقل الاسم مطلوب.' : 'The name field is required.',
            'name.string' => $request->lang === 'ar' ? 'يجب أن يكون الاسم نصًا.' : 'The name must be a string.',
            'name.max' => $request->lang === 'ar' ? 'يجب ألا يزيد الاسم عن 255 حرفًا.' : 'The name may not be greater than 255 characters.',

            'mobile.required' => $request->lang === 'ar' ? 'حقل رقم الهاتف مطلوب.' : 'The mobile number field is required.',
            'mobile.string' => $request->lang === 'ar' ? 'يجب أن يكون رقم الهاتف نصًا.' : 'The mobile number must be a string.',
            'mobile.max' => $request->lang === 'ar' ? 'يجب ألا يزيد رقم الهاتف عن 15 حرفًا.' : 'The mobile number may not be greater than 15 characters.',
            'mobile.unique' => $request->lang === 'ar' ? 'رقم الهاتف هذا مسجل بالفعل.' : 'This mobile number is already registered.',

            'gender.required' => $request->lang === 'ar' ? 'حقل الجنس مطلوب.' : 'The gender field is required.',

            'city.required' => $request->lang === 'ar' ? 'حقل المدينة مطلوب.' : 'The city field is required.',
            'city.string' => $request->lang === 'ar' ? 'يجب أن تكون المدينة نصًا.' : 'The city must be a string.',
            'city.max' => $request->lang === 'ar' ? 'يجب ألا يزيد اسم المدينة عن 100 حرف.' : 'The city may not be greater than 100 characters.',
        ]);

        // Create user
        $validatedData['user_type']  =2;
        $validatedData['status']  =1;
        $user = User::create($validatedData);

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string',
        ]);

        $lang = $request->lang ?? 'en'; // Default to English if $lang is not provided

        // Define messages in both languages
        $messages = [
            'en' => [
                'invalid_input' => 'Invalid input.',
                'driver_not_found' => 'Driver not found.',
                'account_pending' => 'Please wait until your account is approved.',
                'otp_sent' => 'OTP sent to your mobile number.',
            ],
            'ar' => [
                'invalid_input' => 'إدخال غير صالح.',
                'driver_not_found' => 'لم يتم العثور على السائق.',
                'account_pending' => 'يرجى الانتظار حتى تتم الموافقة على حسابك.',
                'otp_sent' => 'تم إرسال رمز OTP إلى رقم جوالك.',
            ]
        ];

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['invalid_input'],
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('mobile', $request->mobile)->where('user_type', 2)->first();


        if (!$user) {
            $user = User::where('name', 'guest@')->where('user_type', 2)->first();
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['driver_not_found'],
            ], 404);
        }

        if (!$user->status) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => $messages[$lang]['account_pending'],
            ], 200);
        }

        // Generate OTP
        $otp = mt_rand(1000, 9999);
        $user->otp = $otp;
        $user->mobile = $request->mobile;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();


        // Send SMS via Taqnyat
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.taqnyat.bearer_token'),
                'Content-Type' => 'application/json',
            ])->post(config('services.taqnyat.url'), [
                'sender' => config('services.taqnyat.sender'),
                'recipients' => [$user->mobile],
                'body' => "Your OTP code is: $otp\nValid for 10 minutes"
            ]);

            if (!$response->successful()) {
                Log::error('Taqnyat SMS Failed', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::info('Taqnyat URL', ['url' => config('services.taqnyat.url')]);
            Log::error('SMS Send Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
            'otp'=>$otp,
            'message' => $messages[$lang]['otp_sent'],
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string',
            'otp' => 'required|string|digits:4',
        ]);

        $lang = $request->lang ?? 'en'; // Default to English if $lang is not provided

        // Define messages in both languages
        $messages = [
            'en' => [
                'invalid_input' => 'Invalid input.',
                'user_not_found' => 'user not found.',
                'account_pending' => 'Please wait until admin approves your account.',
                'invalid_otp' => 'Invalid or expired OTP.',
                'login_success' => 'Login successful.',
            ],
            'ar' => [
                'invalid_input' => 'إدخال غير صالح.',
                'driver_not_found' => 'لم يتم العثور على السائق.',
                'account_pending' => 'يرجى الانتظار حتى يوافق المشرف على حسابك.',
                'invalid_otp' => 'رمز OTP غير صالح أو منتهي الصلاحية.',
                'login_success' => 'تم تسجيل الدخول بنجاح.',
            ]
        ];

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['invalid_input'],
                'errors' => $validator->errors(),
            ], 422);
        }

        $driver = User::where('mobile', $request->mobile)->where('user_type', 2)->where('name','!=','guest@')->first();

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['user_not_found'],
            ], 404);
        }

        if ($driver->status == 0) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['account_pending'],
                'status'=>$driver->status,
            ], 404);
        }

        if ($driver->otp !== $request->otp || now()->gt($driver->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['invalid_otp'],
            ], 401);
        }

        // Clear OTP after successful verification
        $driver->otp = null;
        $driver->save();

        // Generate authentication token
        $token = $driver->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => $messages[$lang]['login_success'],
            'token' => $token,
            'driver' => $driver,
        ], 200);
    }
}
