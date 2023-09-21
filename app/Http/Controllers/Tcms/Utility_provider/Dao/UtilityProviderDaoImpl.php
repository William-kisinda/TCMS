<?php

namespace App\Http\Controllers\Tcms\Utility_provider\Dao;

use App\Http\Controllers\Tcms\Utility_provider\Dto\UtilityProviderDto;
use App\Models\Meter;
use App\Models\Customer;
use App\Models\Provider;
use App\Models\UtilityProviderModel;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

/**
 * This Class Controls Product Category Datastore
 * @author Julius.
 * Email:juliusstephen1@gmail.com
 * 11/09/2023
 *
 */

class UtilityProviderDaoImpl implements UtilityProviderDao
{

    /**
     * @param $meterId
     * @return UtilityProviderModel|null
     * @author Julius M
     */

    public function getUtilityProviderByCode($providerCode)
    {
        $provider = null;

        try {
            $providerInfo = DB::table('utility_providers')->where('provider_code', $providerCode)->first();

            if (!empty($providerInfo)) {
                // If the provider info is found, you can directly create a Provider object.
                $provider = new UtilityProviderModel();
                $provider->setAttributes((array) $providerInfo);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("UtilityProviderException: " . $e->getMessage());
        }

        return $provider;
    }


    /**
     * @param null
     * @return UtilityProviderModel|null
     * @author Julius M
     */
    public function getAllUtilityProviders()
    {
        $utilityProviders = null;
        try {
            $utilityProvidersInfo = DB::table('utility_providers')->get();
            if (!blank($utilityProvidersInfo)) {

                $utilityProvidersInfoArray = json_decode(json_encode($utilityProvidersInfo), true);

                $utilityProviders = new Provider();

                $utilityProviders->setAttributes($utilityProvidersInfoArray);
            }
        } catch (\Exception $exception) {
            Log::info("UtilityProviderException:" . $exception->getMessage());
        }
        return $utilityProviders;
    }

    /**
     * @param UtilityProviderDto $providerDto
     * @return UtilityProviderModel|null
     * @author Julius
     */

    public function createUtilityProvider(UtilityProviderDto $providerDto)
    {
        $utilityProvider = null;
        try {
            $utilityProvider = new UtilityProviderModel();

            // $provider->setProviderCode($providerCategoryDto->getProv_categ_code());
            // $provider->setProviderName($providerCategoryDto->getProv_categ_name());
            $utilityProvider->setAttributes($providerDto->getAttributes());

            $utilityProvider->save();
        } catch (\Exception $e) {
            Log::info("UtilityProviderException:". $e->getMessage());
        }
        return $utilityProvider;
    }
}
