<?php
namespace App\Http\Controllers\Tcms\Debts\Dao;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\tcmsDebt\Dto\DebtDto;
Interface DebtDao{

   public function resolveDebt($meterId, $amount);

   public function getDebtByMeterId($meterId);

  public function assignDebtByMeterId($meterId, $AssigneDebtAmount, $AssignedReductionRate,$description,);
}
