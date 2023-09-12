<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'ProviderCategory\Api', 'prefix' => 'providerCategories'], function () {
    //CREATE/INSERT
    Route::get('/', 'ProviderCategoryApi@getProviderCategories');
    Route::get('/{providerCategoryId}', 'ProviderCategoryApi@getProviderCategoryById');
    Route::post('/', 'ProviderCategoryApi@createProviderCategory');
    //     //GET — Read
    //     Route::get('/{identityTypeId}', 'IdentityTypeApi@getIdentityTypeByIdentityTypeId');
    // //    UPDATE
    //     Route::put('/{identityTpeId}', 'IdentityTypeApi@updateIdentityTypeByIdentityTypeId');
    //     //DELETE
    //     Route::delete('/{identityTpeId}', 'IdentityTypeApi@deleteIdentityTypeByIdentityTypeId');
});
