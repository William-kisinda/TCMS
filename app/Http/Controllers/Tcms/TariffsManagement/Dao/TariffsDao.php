<?php

namespace App\Http\Controllers\Tcms\TariffsManagement\Dao;

use App\Http\Controllers\Tcms\TariffsManagement\Dto\TariffsDto;

/**
 * This interface Access Tariffs Data
 * @author Daniel.
 *
 */

interface TariffsDao
{
    public function getAllTariffs();
    public function getTariffById($tariffId);
    public function getTariffByName($tariffName);
    public function getTariffByCode($tariffCode);
    public function getTariffByNameOrCode($tariffName, $tariffCode);
    public function createTariff(TariffsDto $providerDto);
}
