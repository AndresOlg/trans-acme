<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\VehiculoController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::apiResource('conductores', ConductorController::class);
    Route::apiResource('vehiculos', VehiculoController::class);
    Route::get('vehiculos/filtrar', 'VehiculoController@getByTypeAndBrand');
    Route::get('conductores/vehiculos', 'ConductorController@getVehiculosByConductor');
});





