<?php

namespace App\Http\Controllers\Tcms\TariffsManagement\Dao;

use App\Http\Controllers\Tcms\TariffsManagement\Dto\TariffsDto;
use App\Models\Tariffs;
use App\Models\UtilityProviderModel;
use App\Models\UtilityProviderTariffs;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

/**
 * This Class Controls Tariffs Datastore
 * @author Daniel.
 * Email:danielmathew460@gmail.com
 * 23/09/2023
 *
 */

class TariffsDaoImpl implements TariffsDao
{
    protected $tariffs;

    public function __construct(Tariffs $tariff) {
        $this->tariffs = $tariff;
    }
    /**
     * @param null
     * @return array|null
     * @author Daniel MM
     */
    public function getAllTariffs()
    {
        try {
            $tariffsInfo = DB::table('tariffs')->get();
            if (!blank($tariffsInfo)) {

                $tariffsInfoArray = json_decode(json_encode($tariffsInfo), true);

                $this->tariffs->setAttributes($tariffsInfoArray);
            }
        } catch (\Exception $exception) {
            Log::info("Tariffs Exception:" . $exception->getMessage());
        }
        return $this->tariffs;
    }

    /**
     * @param null
     * @return Tariffs|null
     * @author Daniel MM
     */
    public function getTariffsByUtilityProvider($utilityProviderId)
    {
        $tariffs = null;
        try {
            // $tariffsInfo = DB::table('tariffs')->get();
            $tariffsInfo = UtilityProviderModel::where('id', $utilityProviderId)->with('tariffs')->get();
            if (!blank($tariffsInfo)) {

                $tariffs = $tariffsInfo;
                // $tariffs = json_decode(json_encode($tariffsInfo), true);
            }
        } catch (\Exception $exception) {
            $tariffs = null;
            Log::info("Tariffs Exception:" . $exception->getMessage());
        }
        return $tariffs;
    }

    /**
     * @param $tariffId
     * @return Tariffs|null
     * @author Daniel M
     */

    public function getTariffById($tariffId)
    {

        try {
            $tariffInfo = DB::table('tariffs')->where('id', $tariffId)->first();

            if (!empty($tariffInfo)) {
                // If the tariff info is found, you can directly create a Tariff object.

                $this->tariffs->setAttributes((array) $tariffInfo);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Tariff Exception: " . $e->getMessage());
        }

        return $this->tariffs;
    }


    /**
     * @param $tariffName
     * @return Tariffs|null
     * @author Daniel M
     */

    public function getTariffByName($tariffName)
    {

        try {
            $tariffInfo = DB::table('tariffs')->where('name', $tariffName)->first();

            if (!empty($tariffInfo)) {
                // If the tariff info is found, you can directly create a Tariff object.
                $this->tariffs->setAttributes((array) $tariffInfo);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Tariff Exception: " . $e->getMessage());
        }

        return $this->tariffs;
    }

    /**
     * @param $tariffCode
     * @return Tariffs|null
     * @author Daniel MM
     */

     public function getTariffByCode($tariffCode)
     {

        try {
            $tariffInfo = DB::table('tariffs')->where('code', $tariffCode)->first();

            if (!empty($tariffInfo)) {
                // If the tariff info is found, you can directly create a Tariff object.
                $this->tariffs->setAttributes((array) $tariffInfo);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Tariff Exception: " . $e->getMessage());
        }

        return $this->tariffs;
     }

     /**
     * @param mixed
     * @return Tariffs|null
     * @author Daniel M
     */

    public function getTariffByNameOrCode($tariffName, $tariffCode)
    {

        try {
            $tariffInfo = DB::table('tariffs')->where('name', $tariffName)->orWhere('code', $tariffCode)->first();

            if (!empty($tariffInfo)) {
                // If the tariff info is found, you can directly create a Tariff object.
                $this->tariffs->setAttributes((array) $tariffInfo);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Tariff Exception: " . $e->getMessage());
        }

        return $this->tariffs;
    }

    /**
     * @param TariffsDto $tariffDto
     * @return Tariffs|null
     * @author Daniel MM
     */

     public function createTariff(TariffsDto $tariffDto)
     {
         try {

             $this->tariffs->setAttributes($tariffDto->getAttributes());

             $this->tariffs->save();
         } catch (\Exception $e) {
             Log::info("Tariff Exception:". $e->getMessage());
         }
         return $this->tariffs;
     }

     /**
     * @author Daniel MM
     */

     public function attachTariffsToUtilityProviders($utilityProviderId, $tariffId)
     {
         $utilityProviderTariff = null;
         try {
            $utilityProviderTariffInfo = DB::table('utility_providers_tariffs')->where('utility_provider_id', $utilityProviderId)->where('tariff_id', $tariffId)->get(['id']);

            Log::info("Utility Provider Tariff Info". json_encode($utilityProviderTariffInfo));
            if(blank($utilityProviderTariffInfo)) {
                $utilityProviderTariff = app(UtilityProviderTariffs::class);

                $utilityProviderTariff->setUtilityProvidersId($utilityProviderId);

                $utilityProviderTariff->setTariffId($tariffId);

                $utilityProviderTariff->save();
            } else {
                $utilityProviderTariff = "Tariff Exists";
            }
         } catch (\Exception $e) {
             Log::info("Tariff Exception:". $e->getMessage());
         }
         return $utilityProviderTariff;
     }

      /**
     * @param $tariffCode
     * @return $finalAmount
     * @author Julius
     */
    public function deductTariffByCode($tariffCode,$amount){
        $finalAmount = null;

        try {
            $tariffInfo = DB::table('tariffs')->where('code', $tariffCode)->first();

            if (!empty($tariffInfo)) {
                // If the tariff info is found, you can directly create a Tariff object.
                $this->tariffs->setAttributes((array) $tariffInfo);
                $tariffAmount = $this->tariffs->getTariffAmount();
                $finalAmount = (($amount*$tariffAmount)/100);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Tariff Exception: " . $e->getMessage());
        }
        return $finalAmount;
    }

    /**
     * @param TariffsDto $tariffDto
     * @return Tariffs|null
     * @author Daniel MM
     */
    public function updateTariff(TariffsDto $tariffDto){
         try {
            $tariffInfo = Tariffs::where('id', $tariffDto->getTariff_id())->first();
            $tariffInfo->name = $tariffDto->getTariff_name();
            $tariffInfo->code = $tariffDto->getTariff_code();
            $tariffInfo->percentageAmount = $tariffDto->getTariff_percentageAmount();
            $tariffInfo->value = $tariffDto->getTariff_value();
            $this->tariffs->setAttributes($tariffDto->getAttributes());
            $tariffInfo->update();
         } catch (\Exception $e) {
             Log::info("Tariff Exception:". $e->getMessage());
         }
         return $this->tariffs;
    }
}
