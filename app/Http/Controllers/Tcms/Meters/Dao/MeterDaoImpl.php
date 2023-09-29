<?php

namespace App\Http\Controllers\Tcms\Meters\Dao;

use App\Helpers;
use App\Models\Meter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDao;
use App\Http\Controllers\Tcms\Meters\Dto\MeterDto;

/**
 * This Class Controls Tariffs Datastore
 * @author Daniel.
 * Email:danielmathew460@gmail.com
 * 28/09/2023
 *
 */

 class MeterDaoImpl implements MeterDao
 {
     /**
      * @param $meterId
      * @return Meter|null
      * @author Daniel MM
      */
     public function getMeterById($meterId)
     {
         $meter = null;
         try {
             $meterInfo = DB::table('meters')->where('id', $meterId)->first();
             if (!blank($meterInfo)) {
 
                 $meterInfoArray = json_decode(json_encode($meterInfo), true);
 
                 $meter = new Meter();
                 $meter->setAttributes($meterInfoArray);
             }
         } catch (\Exception $exception) {
             Log::error("MeterId Get Exception", $exception->getMessage());
         }
         return $meter;
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
              $metersInfo = DB::table('meters')->where('customers_id', $customerId)->get(['id', 'meter_number', 'status'], false);
 
              if (!empty($metersInfo)) {
                $meters = $metersInfo;
              }
          } catch (\Exception $e) {
              // Log the exception for debugging purposes.
              Log::error("Customer Meters Fetch Exception: " . $e->getMessage());
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
             $meterInfo = DB::table('meters')->where('meter_number', $meterNumber)->first();
             if (!blank($meterInfo)) {
 
                 $meterInfoArray = json_decode(json_encode($meterInfo), true);
 
                 $meter = new Meter();
                 $meter->setAttributes($meterInfoArray);
             }
         } catch (\Exception $exception) {
             Log::error("Meter Number Check Exception", $exception->getMessage());
         }
         return $meter;
     }
 
     /**
      * @param $customerId
      * @return Meter|null
      * @author Daniel MM
      */
     public function createMeter($customerId)
     {
         $meter = null;
          try {
            $meter = new Meter();

            //Generate Meter Number
            $helper = new Helpers();
            $meter_number = $helper->generateMeterNumber();

            //Check if by any chance the meterNumber has ever been used already.
            while (true) {
                $meter = $this->checkIfMeterExists($meter_number);
                if (is_null($meter)) break;
                $meter_number = $helper->generateMeterNumber();
            }
            
            $meterDto = new MeterDto();
            $meterDto->setAttributes([
                "meter_number" => $meter_number,
                "customers_id" => $customerId,
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