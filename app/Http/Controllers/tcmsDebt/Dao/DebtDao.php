<?php

namespace App\Http\controllers\tcmsDebt\Dao;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\tcmsDebt\Dto\DebtDto;
Interface DebtDao{



 

   public function resolveDebt($meterNumber, $amount);

   public function getDebtByMeterId($meterId);
}
