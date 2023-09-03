<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'ValidationRequest\Api', 'prefix' => 'validate'], function () {
    //CREATE/INSERT
    Route::get('/', 'ValidationApi@validateId');
//     //GET — Read
//     Route::get('/{identityTypeId}', 'IdentityTypeApi@getIdentityTypeByIdentityTypeId');
// //    UPDATE
//     Route::put('/{identityTpeId}', 'IdentityTypeApi@updateIdentityTypeByIdentityTypeId');
//     //DELETE
//     Route::delete('/{identityTpeId}', 'IdentityTypeApi@deleteIdentityTypeByIdentityTypeId');
});
?>