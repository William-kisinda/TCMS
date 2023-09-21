<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tcms\Utility_provider\Api\UtilityProviderApi;
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


Route::middleware(['throttle:5,1'])->group(function () {
        // This route allows up to 5 requests per minute (adjust as needed).

            // get all utility providers
    Route::post('utilityProviders', [UtilityProviderApi::class, 'getAllProviders']);

            //Create a utility provider
    Route::post('utilityProvider', [UtilityProviderApi::class, 'createUtilityProvider']);

            //Get utility provider by code
    Route::post('providerByCode', [UtilityProviderApi::class, 'getProviderByCode']);

});
