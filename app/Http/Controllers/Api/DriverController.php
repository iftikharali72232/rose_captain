<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Models\Vehicle;
use App\Models\Company;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $drivers = User::where('user_type', 1)->with(['company', 'vehicle'])->get();
        return view('drivers.index', compact('drivers'));
    }

    public function store(StoreFormRequest $request)
    {

        $driver = User::where('mobile', $request->mobile)->where('user_type', 1)->where('name', 'guest')->first();

        if ($driver):
            $driver->update([
                'mobile' => 'guest',
                'id_number' => 'guest'
            ]);
        endif;
        $lang = $request->lang;
        $user = User::where('mobile', $request->mobile)->where('user_type',1)->first();
    
        if ($user) {
            return response()->json([
                'success' => false,
                'message' => $lang == "en" ? 'Mobile Number already exists.' : "رقم الجوال موجود بالفعل.",
            ], 404);
        }
        DB::beginTransaction();

        try {
            // Handle image uploads with better naming
            $idImagePath = $request->file('id_image')->store('drivers/ids', 'public');
            $driver_image = $request->file('car_image')->store('drivers/driver', 'public');


            $carImagePath = $request->file('car_image')->store(
                'vehicles/images',
                'public'
            );

            $licenseImagePath = $request->file('license_image')->store(
                'drivers/licenses',
                'public'
            );

            // Create user with both ID and License images
            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'id_number' => $request->id_number,
                'user_type' => 1,
                'id_image' => $idImagePath,
                'license_image_url' => $licenseImagePath,
                'driver_image' => $driver_image,
            ]);

            // Create vehicle with car image
            $vehicle = Vehicle::create([
                'user_id' => $user->id,
                'car_type' => $request->car_type,
                'number_of_passengers' => $request->number_of_passengers,
                'car_model' => $request->car_model,
                'car_color' => $request->car_color,
                'licence_plate_number' => $request->licence_plate_number,
                'car_image' => $carImagePath,
            ]);

            // Create company (without license image)
            $company = Company::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'company_location' => $request->company_location,
                'company_registration_number' => $request->company_registration_number,
                'company_type' => $request->company_type,
            ]);

            Wallet::create(['user_id' => $user->id]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $lang == "en" ? 'Driver registration successful' : "تم تسجيل السائق بنجاح.",
                'data' => [
                    'driver' => $user->append(['id_image_url', 'license_image_url']),
                    'driver_image' => $user->driver_image,
                    'vehicle' => $vehicle->append(['car_image_url']),
                    'company' => $company,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $lang == "en" ? 'Registration failed' : "فشل التسجيل.",
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

}
