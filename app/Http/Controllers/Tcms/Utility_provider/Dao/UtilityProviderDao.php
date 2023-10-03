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
    public function getAllUtilityProviders();
    public function getUtilityProviderByCode($providerCode);
    public function createUtilityProvider(UtilityProviderDto $providerDto);
}
