<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'ProviderCategory\Api', 'prefix' => 'provider_category'], function () {
    //CREATE/INSERT
    Route::get('/', 'ProviderCategoryApi@providerCategories');
    //     //GET — Read
    //     Route::get('/{identityTypeId}', 'IdentityTypeApi@getIdentityTypeByIdentityTypeId');
    // //    UPDATE
    //     Route::put('/{identityTpeId}', 'IdentityTypeApi@updateIdentityTypeByIdentityTypeId');
    //     //DELETE
    //     Route::delete('/{identityTpeId}', 'IdentityTypeApi@deleteIdentityTypeByIdentityTypeId');
});
