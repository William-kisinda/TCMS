<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tcms\MeterValidation\Api\MeterValidateApi;
use App\Http\Controllers\Tcms\ProviderCategory\Api\ProviderCategoryApi;

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


//meter number validation
Route::get('/meter/{meter_num}', [MeterValidateApi::class ,'getValidMeter']);

//utility service provider
Route::post('registerProvider', [ProviderCategoryApi::class , 'createProviderCategory']);

Route::get('lists', [ProviderCategoryApi::class , 'getProviderCategories']);

Route::get('lists/{providerCategoryId}', [ProviderCategoryApi::class,'getProviderCategoryById']);
