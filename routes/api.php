<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api'], function() {
});
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function() {
    Route::get('inquiry/showByRefNum/{referenceNumber}', ['uses' => 'InquiryController@showByRefNum']);
    Route::get('inquiry/show/{id}', ['uses' => 'InquiryController@show']);
    Route::get('inquiry/receive/{id}', ['uses' => 'InquiryController@receive']);
    Route::get('inquiry/invalid/{id}', ['uses' => 'InquiryController@invalid']);
    Route::apiResource('inquiry', InquiryController::class);
    Route::get('vehicle/show/{id}', ['uses' => 'VehicleController@show']);
    Route::put('vehicle/update/{id}', ['uses' => 'VehicleController@update']);
    Route::get('vehicle/setForMaintennance/{id}', ['uses' => 'VehicleController@setForMaintennance']);
    Route::get('vehicle/setOnMaintennance/{id}', ['uses' => 'VehicleController@setOnMaintennance']);
    Route::get('vehicle/setActive/{id}', ['uses' => 'VehicleController@setActive']);
    Route::apiResource('vehicle', VehicleController::class);
    Route::get('user-role/setActive/{id}', ['uses' => 'UserRoleController@setActive']);
    Route::get('user-role/dropdown/', ['uses' => 'UserRoleController@dropdown']);
    Route::get('user-role/setInactive/{id}', ['uses' => 'UserRoleController@setInactive']);
    Route::put('user-role/update/{id}', ['uses' => 'UserRoleController@update']);
    Route::get('user-role/show/{id}', ['uses' => 'UserRoleController@show']);
    Route::apiResource('user-role', UserRoleController::class);
    Route::get('user/setActive/{id}', ['uses' => 'UserController@setActive']);
    Route::get('user/dropdown/', ['uses' => 'UserController@dropdown']);
    Route::get('user/setInactive/{id}', ['uses' => 'UserController@setInactive']);
    Route::put('user/update/{id}', ['uses' => 'UserController@update']);
    Route::get('user/show/{id}', ['uses' => 'UserController@show']);
    Route::apiResource('user', UserController::class);

    Route::get('itemType/dropdown', ['uses' => 'ItemTypeController@dropdown']);
    Route::apiResource('itemtype', ItemTypeController::class);

    Route::get('vehicleMake/dropdown', ['uses' => 'VehicleMakeController@dropdown']);
    Route::apiResource('vehiclemake', VehicleMakeController::class);

    Route::get('vehicleModel/dropdown', ['uses' => 'VehicleModelController@dropdown']);
    Route::apiResource('vehiclemodel', VehicleModelController::class);
    
    Route::get('gasType/dropdown', ['uses' => 'GasTypeController@dropdown']);
    Route::apiResource('gasType', GasTypeController::class);
    
    Route::get('cargoType/dropdown', ['uses' => 'CargoTypeController@dropdown']);
    Route::apiResource('cargotype', CargoTypeController::class);

    // Route::get('session/authenticate', ['uses' => 'SessionController@authenticate'])->name('session.authenticate');
    Route::post('login', ['uses' => 'SessionController@login'])->withoutMiddleware(['auth:sanctum']);
    // Route::get('logout', ['uses' => 'SessionController@logout'])->name('session.logout');
});
