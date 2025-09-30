<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function(){
    Route::post('register',[\App\Http\Controllers\Api\V1\Auth\AuthController::class,'register']);
    Route::post('login',[\App\Http\Controllers\Api\V1\Auth\AuthController::class,'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('inventory',[\App\Http\Controllers\Api\V1\InventoryController::class,'index']);
    Route::post('inventory_transfer',[\App\Http\Controllers\Api\V1\StockTransferController::class,'store']);


    Route::resource('warehouse',\App\Http\Controllers\Api\V1\WarehouseController::class)
        ->only(['index','show']);

    Route::get('warehouse/{id}/inventory', [\App\Http\Controllers\Api\V1\WarehouseController::class, 'inventory']);

});
