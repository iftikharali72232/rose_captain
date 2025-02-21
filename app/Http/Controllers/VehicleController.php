<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // List all vehicles
    public function index()
    {
        $vehicles = Vehicle::with(['user', 'company'])->get();
        return view('vehicles.index', compact('vehicles'));
    }

    // Show the form for creating a new vehicle
    public function create()
    {
        $users = User::all();
        $companies = Company::all();
        return view('vehicles.create', compact('users', 'companies'));
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicles.show', compact('vehicle'));
    }

    // Store a newly created vehicle in the database
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'vehicle_name' => 'required',
            'vin_number' => 'required|unique:vehicles',
            'number_plate' => 'required|unique:vehicles',
            'color' => 'required',
            'model' => 'required',
            'status' => 'required',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    // Show the form for editing the specified vehicle
    public function edit(Vehicle $vehicle)
    {
        $users = User::all();
        $companies = Company::all();
        return view('vehicles.edit', compact('vehicle', 'users', 'companies'));
    }

    // Update the specified vehicle in the database
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'vehicle_name' => 'required',
            'vin_number' => 'required|unique:vehicles,vin_number,' . $vehicle->id,
            'number_plate' => 'required|unique:vehicles,number_plate,' . $vehicle->id,
            'color' => 'required',
            'model' => 'required',
            'status' => 'required',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    // Remove the specified vehicle from the database
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}