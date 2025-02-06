<?php

use App\Http\Controllers\Api\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
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
// protected routes
Route::group(["middleware"=> "auth:sanctum"], function () {
    // Requests

    Route::post('/driver/logout', [AuthController::class, 'logout']);
    Route::post('/driver/logout-all', [AuthController::class, 'logoutFromAllDevices']);
    Route::post('/driver/update-profile', [AuthController::class, 'updateProfile']);

    Route::get('/driver/car', [VehicleController::class, 'show']); // Get car info
    Route::post('/driver/car/update', [VehicleController::class, 'update']); // Update car info
    Route::delete('/driver/delete-account', [AuthController::class, 'deleteAccount']);

});
