<?php

use App\Http\Controllers\Api\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarTypeController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// public routes
Route::post('/drivers', [DriverController::class, 'store']);
Route::post('/driver/login', [AuthController::class, 'login']);
Route::post('/driver/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('car-types', [CarTypeController::class, 'index']);
Route::get('/privacy-policy',[\App\Http\Controllers\Api\PrivacyPolicy::class,'show']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// protected routes
Route::group(["middleware" => "auth:sanctum"], function () {
    // Requests

    Route::post('/driver/logout', [AuthController::class, 'logout']);
    Route::post('/driver/logout-all', [AuthController::class, 'logoutFromAllDevices']);
    Route::patch('/driver/update-profile', [AuthController::class, 'updateProfile']);

    Route::get('/driver/car', [VehicleController::class, 'show']);
    Route::post('/driver/car/update', [VehicleController::class, 'update']);
    Route::get('/driver/company', [CompanyController::class, 'show']);
    Route::post('/driver/company/update', [CompanyController::class, 'update']);
    Route::delete('/driver/delete-account', [AuthController::class, 'deleteAccount']);


    Route::resource('booking',\App\Http\Controllers\Api\BookingController::class);
    Route::resource('wallet',\App\Http\Controllers\Api\WalletController::class);
    Route::resource('subscription',\App\Http\Controllers\Api\SubscritionController::class);
    Route::resource('driver_card',\App\Http\Controllers\Api\DriverCardController::class);

});
