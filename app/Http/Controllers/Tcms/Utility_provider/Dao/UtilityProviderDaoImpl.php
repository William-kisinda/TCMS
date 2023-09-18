<?php
namespace App\Http\Controllers\Tcms\Utility_provider\Dao;

use App\Http\Controllers\Tcms\Utility_provider\Dto\UtilityProviderDto;
use App\Models\Meter;
use App\Models\Customer;
use App\Models\Provider;
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
     * @return Provider|null
     * @author Julius M
     */

     public function getProviderByCode($providerCode)
     {
         $provider = null;

         try {
             $providerInfo = DB::table('utility_providers')->where('provider_code', $providerCode)->first();

             if (!empty($providerInfo)) {
                 // If the provider info is found, you can directly create a Provider object.
                 $provider = new Provider();
                 $provider->setAttributes((array) $providerInfo);
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::error("ProviderException: " . $e->getMessage());
         }

         return $provider;
     }


     /**
     * @param null
     * @return Meter|null
     * @author Julius M
     */
    public function getAllProviders(){
        $customers = null;
        try {
            $providersInfo = DB::table('utility_providers')->get();
            if (!blank($providersInfo)) {

                $providersInfoArray = json_decode(json_encode($providersInfo), true);

                // foreach ($providerCategoriesInfoArray as $prodCategInfo) {
                # code...
                $providers = new Provider();
                $providers->setAttributes($providersInfoArray);

                // array_push($providerCategoryArray, $providerCategory);
                // }
            }
        } catch (\Exception $exception) {
            Log::error("ProvidersException", $exception->getMessage());
        }
        return $providers;
    }

     /**
     * @param UtilityProviderDto $providerDto
     * @return Provider|null
     * @author Julius
     */

     public function createProvider(UtilityProviderDto $providerDto)
     {
         $provider = null;
         try {
             $provider = new Provider();

            // $provider->setProviderCode($providerCategoryDto->getProv_categ_code());
            // $provider->setProviderName($providerCategoryDto->getProv_categ_name());
            $provider->setAttributes($providerDto->getAttributes());

             $provider->save();
         } catch (\Exception $e) {
             Log::error("ProviderException", $e->getMessage());
         }
         return $provider;
     }

}
