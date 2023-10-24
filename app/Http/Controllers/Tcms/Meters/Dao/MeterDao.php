<?php

namespace App\Http\Controllers\Tcms\Meters\Dao;

use App\Http\Controllers\Tcms\Meters\Dto\MeterDto;

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
    public function createMeter(MeterDto $customerDto, $utility_provider_id);
}
