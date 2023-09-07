<?php

namespace App\Http\Controllers\Tcms\ProviderCategory\Dao;

use App\Http\Controllers\Tcms\ProviderCategory\Dto\ProviderCategoryDto;


/**
 * This interface Access ProductCategory Data
 * @author Daniel MM.
 *
 */

interface ProviderCategoryDao
{
    public function getProviderCategories();
    public function getProviderCategoryById($providerCategoryId);
    public function createProviderCategory(ProviderCategoryDto $providerCategoryDto);
    public function getProviderCategoryByNameOrCode($providerCategoryName, $providerCategoryCode);
}
