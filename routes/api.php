<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tcms\Auth\Api\AuthController;
use App\Http\Controllers\Tcms\Debts\Api\DebtManageApi;
use App\Http\Controllers\Tcms\TokenGeneration\Api\ApiEngine;
use App\Http\Controllers\Tcms\TariffsManagement\Api\TariffsApi;
use App\Http\Controllers\Tcms\Customers\Api\CustomersController;
use App\Http\Controllers\Tcms\MeterValidation\Api\MeterValidateApi;
use App\Http\Controllers\Tcms\Utility_provider\Api\UtilityProviderApi;
use App\Http\Controllers\Tcms\ProviderCategory\Api\ProviderCategoryApi;
use App\Http\Controllers\Tcms\TokenGeneration\Api\TokenGenerateController;

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
Route::post('registerProviderCategory', [ProviderCategoryApi::class, 'createProviderCategory']);

//list all provider categories
Route::post('listProviderCategories', [ProviderCategoryApi::class, 'getProviderCategories']);

//get provider categories by their Id
Route::post('listProviderCategory', [ProviderCategoryApi::class, 'getProviderCategoryById']);

/**
 *  Route to handle user authentication.
 * @author Daniel.
 *
 */

// Route::middleware([])->group(function () {
// This route allows up to 5 requests per minute (adjust as needed).

//Create a user
Route::post('user/create', [AuthController::class, 'createUPUser']);

// get all users
Route::post('users', [AuthController::class, 'getUPUsers']);

// get all users
Route::post('user/show', [AuthController::class, 'getUPUserById']);

// get all users
Route::post('user/update', [AuthController::class, 'updateUPUser']);

// });


/**
 *
 * @author Daniel.
 *
 */
// get all utility providers
Route::post('utilityProviders', [UtilityProviderApi::class, 'getAllProviders']);

// get all utility providers with no users
Route::post('utilityProvidersWithNoUsers', [UtilityProviderApi::class, 'getAllProvidersWithNoUsers']);

//Create a utility provider
Route::post('utilityProvider', [UtilityProviderApi::class, 'createUtilityProvider']);

//Update Utility Provider
Route::patch('utilityProvider', [UtilityProviderApi::class, 'updateUtilityProvider']);

//Get utility provider by code
Route::post('providerByCode', [UtilityProviderApi::class, 'getProviderByCode']);

//Get utility provider by id
Route::post('utilityProviderById', [UtilityProviderApi::class, 'getProviderById']);


/**
 *
 * @author Daniel.
 *
 */

Route::middleware([])->group(function () {
        // This route allows up to 5 requests per minute (adjust as needed).

        // get all tariffs
        Route::post('tariffs', [TariffsApi::class, 'getAllTariffs']);

        //Create a tariff
        Route::post('tariff', [TariffsApi::class, 'createTariff']);

        //Get Tariff By Id
        Route::post('tariffById', [TariffsApi::class, 'getTariffById']);

        //Get Tariff By Name
        Route::post('tariffByName', [TariffsApi::class, 'getTariffByName']);

        //Get Tariff By Code
        Route::post('tariffByCode', [TariffsApi::class, 'getTariffByCode']);

        //Get Tariff By Name Or Code
        Route::post('tariffByNameOrCode', [TariffsApi::class, 'getTariffByNameOrCode']);

        //Update Tariff
        Route::patch('tariff', [TariffsApi::class, 'updateTariff']);
});


Route::middleware([])->group(function () {
// get all customers
 Route::post('customers', [CustomersController::class, 'getAllCustomers']);

 // get all customers
 Route::post('customerById', [CustomersController::class, 'getCustomerById']);

 // get all customers
 Route::post('customer/create', [CustomersController::class, 'createCustomer']);
});

/**
 * API Routes for Token Management
 * @author Julius.
 *
 */
//token Generator
Route::post('token-generator', [TokenGenerateController::class, 'generateToken']);
//token receiver , API that might be exposed by the client systems
Route::post('token-receiver', [ApiEngine::class,'tokenReceiver']);

/**
 *
 * @author Hamphrey Urio.
 *
 */
 Route::middleware([])->group(function () {
        Route::post('/assigndebt', [DebtManageApi::class, 'assignDebt']);
        Route::post('/debtresolve', [DebtManageApi::class, 'resolve']);
        Route::post('/meterdebt', [DebtManageApi::class, 'getDebtByMeterId']);
});

/**
 * API Routes for Meter validation
 * @author Julius.
 *
 */
Route::post('/meter', [MeterValidateApi::class, 'getValidMeter']);
