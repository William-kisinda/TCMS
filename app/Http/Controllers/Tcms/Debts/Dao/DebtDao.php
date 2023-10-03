<?php

namespace App\Http\Controllers\Tcms\Debts\Dao;

use App\Http\Controllers\Tcms\Debts\Dto\DebtDto;

interface DebtDao{

   public function assignDebt(DebtDto $debtDto, $update = false);

   public function resolveDebt($meterNumber, $amount);

   public function getDebtByMeterId($meterId);
}
