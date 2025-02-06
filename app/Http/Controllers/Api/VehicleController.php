<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    // Get car information
    public function show(Request $request)
    {
        $user = $request->user();
        $vehicle = Vehicle::where('user_id', $user->id)->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'No car information found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'vehicle' => $vehicle,
        ], 200);
    }

    // Update car information
    public function update(Request $request)
    {
        $user = $request->user();
        $vehicle = Vehicle::where('user_id', $user->id)->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'No car information found.',
            ], 404);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'car_type' => 'sometimes|string',
            'number_of_passengers' => 'sometimes|integer|min:1',
            'car_model' => 'sometimes|string',
            'car_color' => 'sometimes|string',
            'licence_plate_number' => 'sometimes|string|unique:vehicles,licence_plate_number,' . $vehicle->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update car details
        $vehicle->update($request->only([
            'car_type',
            'number_of_passengers',
            'car_model',
            'car_color',
            'licence_plate_number',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Car information updated successfully.',
            'vehicle' => $vehicle,
        ], 200);
    }
}

