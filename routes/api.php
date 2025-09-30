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
