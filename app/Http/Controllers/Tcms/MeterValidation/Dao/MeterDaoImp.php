<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Dao;

use App\Models\Meter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\MeterValidation\Dao\MeterDao;


/**
 * This Class Controls Product Category Datastore
 * @author Julius.
 * Email:juliusstephen1@gmail.com
 * 11/09/2023
 *
 */

class MeterDaoImp implements MeterDao
{

    /**
     * @param $meterId
     * @return Meter|null
     * @author Julius M
     */

     public function getMeterById($meterNumber)
{
    $meter = null;

    try {
        $meterInfo = DB::table('meters')->where('meter_number', $meterNumber)->first();

        if (!empty($meterInfo)) {
            // If the meter info is found, you can directly create a Meter object.
            $meter = new Meter();
            $meter->setAttributes((array) $meterInfo);
        }
    } catch (\Exception $e) {
        // Log the exception for debugging purposes.
        Log::error("MeterException: " . $e->getMessage());
    }

    return $meter;
}


     /**
     * @param null
     * @return Meter|null
     * @author Julius M
     */
    public function getAllMeters(){
        $meters = null;
        try {
            $metersInfo = DB::table('meters')->get();
            if (!blank($metersInfo)) {

                $metersInfoArray = json_decode(json_encode($metersInfo), true);

                // foreach ($providerCategoriesInfoArray as $prodCategInfo) {
                # code...
                $meters = new Meter();
                $meters->setAttributes($metersInfoArray);

                // array_push($providerCategoryArray, $providerCategory);
                // }
            }
        } catch (\Exception $exception) {
            Log::error("MetersException", $exception->getMessage());
        }
        return $meters;
    }

}
