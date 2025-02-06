<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the driver by mobile number
        $driver = Driver::where('mobile', $request->mobile)->first();

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found.',
            ], 404);
        }

        // Generate a new token
        $token = $driver->createToken('DriverAuthToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token' => $token,
            'driver' => $driver,
        ], 200);
    }
    public function logout(Request $request)
    {
        // Revoke the currently authenticated driver's token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
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
        $user = $request->user(); // Get the authenticated driver

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'mobile' => 'sometimes|string|max:20|unique:drivers,mobile,' . $user->id,
            'id_number' => 'sometimes|string|max:20|unique:drivers,id_number,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update profile fields only if provided
        $user->update($request->only(['name', 'mobile', 'id_number']));

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
