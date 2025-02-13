<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;

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

