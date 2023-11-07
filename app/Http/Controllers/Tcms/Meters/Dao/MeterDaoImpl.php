<?php

namespace App\Http\Controllers\Tcms\Meters\Dao;

use App\Helpers;
use App\Models\Meter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDao;
use App\Http\Controllers\Tcms\Meters\Dto\MeterDto;
use App\Http\Controllers\Tcms\Utility_provider\Dao\UtilityProviderDaoImpl;


/**
 * This Class Controls Meters Datastore
 * @author Daniel.
 * Email:danielmathew460@gmail.com
 * 28/09/2023
 *
 */

 class MeterDaoImpl implements MeterDao
 {

      protected $meters;

      public function __construct(Meter $meter)
    {
        $this->meters = $meter;
    }

     /**
      * @param $meterId
      * @return Meter|null
      * @author Daniel MM
      */
     public function getMeterById($meterId)
     {
         try {
             $meterInfo = DB::table('meters')->where('id', $meterId)->first();
             if (!blank($meterInfo)) {

                 $meterInfoArray = json_decode(json_encode($meterInfo), true);

                 $this->meters->setAttributes($meterInfoArray);

             }
             $this->meters= null;
         } catch (\Exception $exception) {
             Log::error("MeterId Get Exception", [$exception->getMessage()]);
         }

         return $this->meters;
     }

     /**
      * @param $meterId
      * @return array|null
      * @author Daniel MM
      */

      public function getMeterByCustomerId($customerId)
      {
          $meters = null;

          try {
              $metersInfo = DB::table('meters')->where('customers_id', $customerId)->get(['id', 'meternumber', 'status'], false);

              if (!empty($metersInfo)) {
                $meters = $metersInfo;

                $metersData = [];
                //Resolve meter with their debts
                $debt = 0;
                foreach($meters as $meter) {
                    $debtInfo = DB::table('debts')->where('meters_id', $meter->id)->first();
                    if (!empty($debtInfo)) {
                        $newMeterInfo = [
                            'id' => $meter->id,
                            'meter_number' => $meter->meternumber
                        ];
                        array_push($metersData, $newMeterInfo);
                    } else {
                        $newMeterInfo = [
                            'id' => $meter->id,
                            'meter_number' => $meter->meternumber,
                        ];
                        array_push($metersData, $newMeterInfo);
                    }
                }
                $meters = $metersData;
              }
          } catch (\Exception $e) {
              // Log the exception for debugging purposes.
              Log::error("Customer Meters Debts Fetch Exception: " . $e->getMessage());
          }

          return $meters;
      }

      /**
      * @param $meterNumber
      * @return Meter|null
      * @author Daniel MM
      */
     public function checkIfMeterExists($meterNumber)
     {
        $meter = null;

         try {

            $meterInfo = DB::table('meters')->where('meternumber', $meterNumber)->first();

            if (!blank($meterInfo)) {

            $meterInfoArray = json_decode(json_encode($meterInfo), true);
            $meter = new Meter();
            $meter->setAttributes($meterInfoArray);
            }
         } catch (\Exception $exception) {
            $this->meters= null;
            Log::error("Meter Number Check Exception", [$exception->getMessage()]);
         }
         return $meter;
     }

     /**
      * @param $meterNumber
      * @return Meter|null
      * @author Daniel MM
      */
      public function checkIfMeterOfUtilityProviderExists($meterNumber, $utility_provider_id)
      {
        $meters = null;

        try {

            $meterInfo = DB::table('meters')->where('meternumber', $meterNumber)->where('utility_provider_id', $utility_provider_id)->first();
            
            if (!blank($meterInfo)) {

                $meterInfoArray = json_decode(json_encode($meterInfo), true);

                $meters = new Meter();
                $meters->setAttributes($meterInfoArray);
            }
        } catch (\Exception $exception) {
            Log::error("Meter Number Check Exception", [$exception->getMessage()]);
        }
        return $meters;
      }

     /**
      * @param $customerId
      * @return Meter|null
      * @author Daniel MM
      */
     public function createMeter($customerId, $utility_provider_id)
     {
        $meter = null;
          try {

            //Generate Meter Number
            $helper = app(Helpers::class);

            //Resolve for utility_provider_code so we can use to generate meter_number.
            $utilityProviderDao = app(UtilityProviderDaoImpl::class);
            $utility_provider = $utilityProviderDao->getUtilityProviderById($utility_provider_id);
            $utility_provider_code = "";
            if (!is_null($utility_provider)){
                $utility_provider_code = $utility_provider->getUtilityProviderCode();
            };

            $meter_number = $helper->generateMeterNumber($utility_provider_code);

            //Check if by any chance the meterNumber has ever been used already.
            while (true) {
                $meterCheck = $this->checkIfMeterExists($meter_number);
                if (is_null($meterCheck)) break;
                $meter_number = $helper->generateMeterNumber($utility_provider_code);
            }

            $meter = new Meter();

            $meterDto = new MeterDto();

            $meterDto->setAttributes([
                "meternumber" => $meter_number,
                "customers_id" => $customerId,
                "utility_provider_id" => $utility_provider_id,
                "status" => "Active"
            ]);

            Log::info("Meter Attributes:". json_encode($meterDto->getAttributes()));

            $meter->setAttributes($meterDto->getAttributes());
            $meter->save();

          } catch (\Exception $e) {
            Log::info("Meter Creation Exception:". $e->getMessage());
          }
          return $meter;
     }
 }
