<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\CarTypeController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Register API routes for your application. Public routes don't require
| authentication, while protected routes require API authentication.
|
*/

// 🔹 Public Routes (No authentication required)
Route::post('/drivers', [DriverController::class, 'store']); // Register driver
Route::post('/driver/login', [AuthController::class, 'login']); // Driver login
Route::post('/driver/verify-otp', [AuthController::class, 'verifyOtp']); // OTP verification
Route::get('/car-types', [CarTypeController::class, 'index']); // Get car types

// 🔹 Protected Routes (Require authentication via auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    // 🚗 Driver Auth & Profile
    Route::post('/driver/logout', [AuthController::class, 'logout']); // Logout from current device
    Route::post('/driver/logout-all', [AuthController::class, 'logoutFromAllDevices']); // Logout from all devices
    Route::post('/driver/update-profile', [AuthController::class, 'updateProfile']); // Update driver profile

    // 🚘 Vehicle Management
    Route::get('/driver/car', [VehicleController::class, 'show']); // View car details
    Route::post('/driver/car/update', [VehicleController::class, 'update']); // Update car details

    // 🏢 Company Details
    Route::get('/driver/company', [CompanyController::class, 'show']); // Get company info
    Route::post('/driver/company/update', [CompanyController::class, 'update']); // Update company info

    // ❌ Account Management
    Route::delete('/driver/delete-account', [AuthController::class, 'deleteAccount']); // Delete driver account

});
