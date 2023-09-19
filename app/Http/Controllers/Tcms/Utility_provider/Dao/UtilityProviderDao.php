<?php

namespace App\Http\Controllers\Tcms\Utility_provider\Dao;

use App\Http\Controllers\Tcms\Utility_provider\Dto\UtilityProviderDto;

/**
 * This interface Access ProductCategory Data
 * @author Julius.
 *
 */

interface UtilityProviderDao
{
    public function getAllProviders();
    public function getProviderByCode($providerCode);
    public function createProvider(UtilityProviderDto $providerDto);
    //public function deleteProvider();
    //public function updateProvider();
    //public function getMeterByIdOrName();
}
