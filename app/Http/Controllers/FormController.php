<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Company;
use App\Http\Requests\StoreFormRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function create()
    {
        return view('drivers.create'); // Render the form view
    }

    public function store(StoreFormRequest $request)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create the user
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
                'company_registration_number' => $request->company_registration_number,
                'company_type' => $request->company_type,
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Form submitted successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    // List all drivers (Users with user_type = 1)
    public function drivers()
    {
        $drivers = User::where('user_type', 1)->get();
        return view('drivers.index', compact('drivers'));
    }

    // List all vehicles along with the user's name
    public function vehicles()
    {
        $vehicles = Vehicle::with('user')->get();
        return view('vehicles.index', compact('vehicles'));
    }

    // List all companies along with the owner's name
    public function companies()
    {
        $companies = Company::with('user')->get();
        return view('companies.index', compact('companies'));
    }
}
