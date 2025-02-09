<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Company;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function store(StoreFormRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create the user (driver)
            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'id_number' => $request->id_number,
                'user_type' => 1,
            ]);

            // Create the vehicle
            $vehicle = Vehicle::create([
                'user_id' => $user->id,
                'car_type' => $request->car_type,
                'number_of_passengers' => $request->number_of_passengers,
                'car_model' => $request->car_model,
                'car_color' => $request->car_color,
                'licence_plate_number' => $request->licence_plate_number,
            ]);

            // Create the company
            $company = Company::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'company_location' => $request->company_location,
                'company_registration_number' => $request->company_registration_number,
                'company_type' => $request->company_type,
            ]);
            Wallet::create([
                'user_id' => $user->id
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Driver, vehicle, and company created successfully.',
                'data' => [
                    'driver' => $user,
                    'vehicle' => $vehicle,
                    'company' => $company,
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

