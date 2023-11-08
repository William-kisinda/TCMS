<?php

namespace App\Http\Controllers\Tcms\Meters\Dao;

use App\Http\Controllers\Tcms\MeterValidation\Dto\ValidMeterDto;

/**
 * This interface Access Meters Data
 * @author Daniel.
 *
 */

interface MeterDao
{
    public function getMeterById($meterId);
    public function getMeterByCustomerId($customerId);
    public function checkIfMeterExists($meterNumber);
    public function createMeter(ValidMeterDto $customerDto, $utility_provider_id);
}
