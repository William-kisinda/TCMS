<?php

namespace App\Http\Controllers\Tcms\Utility_provider\Dao;

use App\Http\Controllers\Tcms\Utility_provider\Dto\UtilityProviderDto;
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
    private $utilityProviderModel;

    public function __construct(UtilityProviderModel $utilityProviderModel) {
        $this->utilityProviderModel = $utilityProviderModel;
    }

    /**
     * @param $providerCode
     * @return UtilityProviderModel|null
     * @author Julius M
     */

    public function getUtilityProviderByCode($providerCode)
    {

        try {
            $providerInfo = DB::table('utility_providers')->where('provider_code', $providerCode)->first();

            if (!empty($providerInfo)) {
                // If the provider info is found, you can directly create a Provider object.
                $this->utilityProviderModel->setAttributes((array) $providerInfo);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("UtilityProviderException: " . $e->getMessage());
        }

        return $this->utilityProviderModel;
    }

    /**
     * @param $providerId
     * @return UtilityProviderModel|null
     * @author Julius M
     */

     public function getUtilityProviderById($providerId)
     {

         try {
             $providerInfo = DB::table('utility_providers')->where('id', $providerId)->first();

             if (!empty($providerInfo)) {
                 // If the provider info is found, you can directly create a Provider object.
                 $this->utilityProviderModel->setAttributes((array) $providerInfo);
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::info("UtilityProviderException: " . $e->getMessage());
         }

         return $this->utilityProviderModel;
     }

    /**
     * @param $providerCode
     * @return UtilityProviderModel|null
     * @author Julius M
     */

     public function getUtilityProviderByNameOrCode($providerName, $providerCode)
     {
         try {
             $providerInfo = DB::table('utility_providers')->where('provider_name', $providerName)->orWhere('provider_code', $providerCode)->first();

             if (!empty($providerInfo)) {
                 // If the provider info is found, you can directly create a Provider object.
                 $this->utilityProviderModel->setAttributes((array) $providerInfo);
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::info("UtilityProviderException: " . $e->getMessage());
         }

         return $this->utilityProviderModel;
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

                $utilityProviders = app(Provider::class);

                $utilityProviders->setAttributes($utilityProvidersInfoArray);
            }
        } catch (\Exception $exception) {
            Log::info("UtilityProviderException:" . $exception->getMessage());
        }
        return $utilityProviders;
    }

    /**
     * @param null
     * @return UtilityProviderModel|null
     * @author Daniel MM
     */
    public function getAllUtilityProvidersWithNoUsers()
    {
        $utilityProviders = null;
        try {
            $utilityProvidersInfo = UtilityProviderModel::doesntHave('user')->get(['id', 'provider_name']);
            Log::info("UtilityProviders with no users:" . json_encode($utilityProvidersInfo));
            if (!blank($utilityProvidersInfo)) {

                $utilityProvidersInfoArray = json_decode(json_encode($utilityProvidersInfo), true);

                $utilityProviders = app(Provider::class);

                $utilityProviders->setAttributes($utilityProvidersInfoArray);
            }
        } catch (\Exception $exception) {
            Log::error("UtilityProviderQueryException:" . $exception->getMessage());
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
        try {
            $this->utilityProviderModel->setAttributes($providerDto->getAttributes());

            $this->utilityProviderModel->save();
        } catch (\Exception $e) {
            Log::info("UtilityProviderException:". $e->getMessage());
        }
        return $this->utilityProviderModel;
    }

    /**
     * @param UtilityProviderDto $providerDto
     * @return UtilityProviderModel|null
     * @author Daniel MM
     */
     public function updateUtilityProvider(UtilityProviderDto $providerDto)
     {
         try {
            $utilityProviderInfo = UtilityProviderModel::where('id', $providerDto->getProvider_id())->first();
            $utilityProviderInfo->provider_name = $providerDto->getProvider_name();
            $utilityProviderInfo->provider_code = $providerDto->getProvider_code();
            $utilityProviderInfo->provider_status = $providerDto->getProvider_status();
            $utilityProviderInfo->provider_categories_id = $providerDto->getProvider_categories_id();
            $this->utilityProviderModel->setAttributes($providerDto->getAttributes());
            $utilityProviderInfo->update();
         } catch (\Exception $e) {
             Log::info("UtilityProviderException:". $e->getMessage());
         }
         return $this->utilityProviderModel;
     }
}
