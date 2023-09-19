<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Dao;


/**
 * This interface Access ProductCategory Data
 * @author Julius.
 *
 */

interface MeterDao
{
    public function getAllMeters();
    public function getMeterById($meterId);
    //public function createMeter();
    //public function deleteMeter();
    //public function updateMeter();
    //public function getMeterByIdOrName();
}
