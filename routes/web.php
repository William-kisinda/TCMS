<?php

use App\Http\Controllers\Client\UtilityProvider\ManageUtilityProviderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/login', [LoginController::class, 'index'])->name('login');
// Route::get('/register', [RegisterController::class, 'index'])->name('register');

// // ['middleware' => ['auth']],
// Route::group([], function () {
//     // Route::resource('roles', RoleController::class);
//     Route::resource('utility_providers', ManageUtilityProviderController::class);
//     Route::resource('provider_category', RegisterController::class);
// });
// Route::get('/utility_providers', [ManageUtilityProviderController::class, 'index'])->name('manage_utility_providers');
// Route::get('/manage_tokens', [RegisterController::class, 'index'])->name('manage_tokens');
