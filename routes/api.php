<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tcms\Roles\RolesController;
use App\Http\Controllers\Tcms\Auth\Api\AuthController;
use App\Http\Controllers\Tcms\Debts\Api\DebtManageApi;
use App\Http\Controllers\Tcms\TokenGeneration\Api\ApiEngine;
use App\Http\Controllers\Tcms\gui\Api\DashboardDataController;
use App\Http\Controllers\Tcms\TariffsManagement\Api\TariffsApi;
use App\Http\Controllers\Tcms\Customers\Api\CustomersController;
use App\Http\Controllers\Tcms\TokenGeneration\Api\NotificationApi;
use App\Http\Controllers\Tcms\MeterValidation\Api\MeterValidateApi;
use App\Http\Controllers\Tcms\Utility_provider\Api\UtilityProviderApi;
use App\Http\Controllers\Tcms\ProviderCategory\Api\ProviderCategoryApi;
use App\Http\Controllers\Tcms\TokenGeneration\Api\TokenGenerateController;
use App\Http\Controllers\Tcms\Users\Api\UsersController;

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
 *  Route to handle user Authentication.
 * @author Daniel.
 *
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

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
 *  Route to handle users.
 * @author Daniel.
 *
 */
//Create a user
Route::post('user/create', [UsersController::class, 'createUPUser']);

// get all users
Route::post('users', [UsersController::class, 'getUPUsers']);

// get all users
Route::post('user/show', [UsersController::class, 'getUPUserById']);

// get all users
Route::post('user/update', [UsersController::class, 'updateUPUser']);


/**
 *
 * API Routes for Utility Providers Management
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
 * API Routes for Tariffs Management
 * @author Daniel.
 *
 */
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

//Get Tariff By Utility Provider
Route::post('tariffsByUtilityProvider', [TariffsApi::class, 'getTariffsByUtilityProvider']);

//Update Tariff
Route::patch('tariff', [TariffsApi::class, 'updateTariff']);


/**
 * API Routes for Customers Management
 * @author Daniel.
 *
 */
// get all customers
Route::post('customers', [CustomersController::class, 'getAllCustomers']);

// get all customers
Route::post('customerById', [CustomersController::class, 'getCustomerById']);

// get all customers
Route::post('customer/create', [CustomersController::class, 'createCustomer']);

/**
 * API Routes for Roles Management
 * @author Daniel.
 *
 */
// get all roles
Route::post('roles', [RolesController::class, 'getRoles']);


/**
 * API Routes for Token Management
 * @author Julius.
 *
 */
//token Generator
Route::post('token-generator', [TokenGenerateController::class, 'produceMessages']);

//token receiver , API that might be exposed by the client systems
Route::post('token-receiver', [ApiEngine::class, 'tokenNotifications']);

/**
 *
 * @author Hamphrey Urio.
 *
 */
Route::post('/assigndebt', [DebtManageApi::class, 'assignDebt']);
Route::post('/debtresolve', [DebtManageApi::class, 'resolve']);
Route::post('/meterdebt', [DebtManageApi::class, 'getDebtByMeterId']);


/**
 * API Routes for Meter validation
 * @author Julius.
 *
 */

//validate Meter information
Route::post('/meter', [MeterValidateApi::class, 'getValidMeter']);


/**
 * API Routes for fetching resources to the user
 * @author Julius.
 *
 */

//Notification API
Route::post('/notification', [NotificationApi::class, 'todayTokens']);

//Dashboard Data collection API
Route::post('/dashboardData', [DashboardDataController::class,'dashboardData']);
