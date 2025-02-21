<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User as Users;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {

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

        $driver = User::where('mobile', $request->mobile)->where('user_type', 1)->first();


        if (!$driver) {
            $driver = User::where('name', 'guest')->where('user_type', 1)->first();
        }

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['driver_not_found'],
            ], 404);
        }

        if (!$driver->status) {
            return response()->json([
                'success' => true,
                'user' => $driver,
                'message' => $messages[$lang]['account_pending'],
            ], 200);
        }

        // Generate OTP
        $otp = mt_rand(1000, 9999);
        $driver->otp = $otp;
        $driver->mobile = $request->mobile;
        $driver->otp_expires_at = now()->addMinutes(10);
        $driver->save();


        // Send SMS via Taqnyat
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.taqnyat.bearer_token'),
                'Content-Type' => 'application/json',
            ])->post(config('services.taqnyat.url'), [
                'sender' => config('services.taqnyat.sender'),
                'recipients' => [$driver->mobile],
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
            'user' => $driver,
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
                'driver_not_found' => 'Driver not found.',
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

        $driver = User::where('mobile', $request->mobile)->where('user_type', 1)->where('name','!=','guest')->first();

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => $messages[$lang]['driver_not_found'],
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

    public function logout(Request $request)
    {
        $lang = $request->lang ?? 'en'; // Default to English if $lang is not provided

        $messages = [
            'en' => ['logout_success' => 'Logout successful.'],
            'ar' => ['logout_success' => 'تم تسجيل الخروج بنجاح.']
        ];

        // Revoke the currently authenticated driver's token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => $messages[$lang]['logout_success'],
        ], 200);
    }

    public function logoutFromAllDevices(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out from all devices.',
        ], 200);
    }
    public function updateProfile(Request $request)
    {
        if ($request->verify == 'false'):
            try {

                $mobile =  Auth::user()->mobile;


                $driver = new Users();
                $driver = $driver->find(Auth::id());


                $otp = mt_rand(1000, 9999);

                $driver->otp = $otp;
                //    $driver->mobile = $request->mobile;
                $driver->otp_expires_at = now()->addMinutes(10);
                $driver->save();
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.taqnyat.bearer_token'),
                    'Content-Type' => 'application/json',
                ])->post(config('services.taqnyat.url'), [
                    'sender' => config('services.taqnyat.sender'),
                    'recipients' => [$mobile],
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
            $lang = $request->lang ?? 'en';
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
            return response()->json([
                'success' => true,
                'user' => $driver,
                'otp'=>$otp,
                'message' => $messages[$lang]['otp_sent'],
            ], 200);
        endif;

        $user = $request->user(); // Get authenticated user

        // Validate the request without requiring 'id'
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'mobile' => 'sometimes|string|max:20|unique:users,mobile,' . $user->id,
            'id_number' => 'sometimes|string|max:20|unique:users,id_number,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update all fields provided in the request
        $updateData = $request->except(['id']);
        \Log::info('Updating user with data:', $updateData);

        $user->update($updateData);

        // Refresh to get updated values from the database
        $user->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'driver' => $user,
        ], 200);
    }


    public function deleteAccount(Request $request)
    {
        $user = $request->user(); // Get authenticated driver

        DB::beginTransaction(); // Start transaction

        try {
            // Delete associated vehicle
            $vehicle = Vehicle::where('user_id', $user->id);
            if ($vehicle) {
                $vehicle->delete();
            }

            // Delete associated company
            $company = Company::where('user_id', $user->id);
            if ($company) {
                $company->delete();
            }

            // Revoke all tokens (logout)
            $user->tokens()->delete();

            // Delete driver account
            $user->delete();

            DB::commit(); // Commit transaction

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the account.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
