<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tcms\MeterValidation\Api\MeterValidateApi;
use App\Http\Controllers\Tcms\Utility_provider\Api\UtilityProviderApi;
use App\Http\Controllers\Tcms\ProviderCategory\Api\ProviderCategoryApi;
use App\Http\Controllers\Client\UtilityProvider\ManageUtilityProviderController;

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
Route::post('/meter', [MeterValidateApi::class, 'getValidMeter']); //tanesco api

/**
 * Below are are the route for the utility provider categories
 * @author Julius.
 *
 */
//register provider category
Route::post('registerProviderCategories', [ProviderCategoryApi::class, 'createProviderCategory']);

//list all register provider categories
Route::get('listsProviderCategories', [ProviderCategoryApi::class, 'getProviderCategories']);

//get provider categories by their Id
Route::get('lists/{providerCategoryId}', [ProviderCategoryApi::class, 'getProviderCategoryById']);



/**
 * Below are the route for the crude api for the utility providers
 * @author Daniel.
 *
 */
// get all utility providers
Route::get('utilityProviders', [UtilityProviderApi::class, 'getAllProviders']);

//Create a utility provider
Route::post('utilityProvider', [UtilityProviderApi::class, 'createUtilityProvider']);

//Get utility provider by code
Route::get('utilityProviders/{providerCode}', [UtilityProviderApi::class, 'getProviderByCode']);
