<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User as Users;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Auth;
class CompanyController extends Controller
{
    // Get car information
    public function show(Request $request)
    {
        $user = $request->user();
        $vehicle = Company::where('user_id', $user->id)->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'No company information found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'company' => $vehicle,
        ], 200);
    }

    // Update car information
    public function update(Request $request)
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
        // Find company linked to the user
        $company = Company::where('user_id', auth()->user()->id)->first();

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'No company information found.',
            ], 404);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'company_name' => 'sometimes|string',
            'company_registration_number' => 'sometimes|string', // Fixed: It's VARCHAR in DB
            'company_type' => 'sometimes', // Fixed: It's VARCHAR in DB
            'company_location' => 'sometimes|string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update company details
        $company->update($request->only([
            'company_name',
            'company_registration_number',
            'company_type',
            'company_location',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Company information updated successfully.',
            'company' => $company,
        ], 200);
    }
}

