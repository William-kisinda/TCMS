<?php
namespace App\Http\Controllers\Tcms\Debts\Dao;


Interface DebtDao{

   public function resolveDebt($meterId, $amount);

   public function getDebtByMeterId($meterId);

  public function assignDebtByMeterId($meterId, $AssigneDebtAmount, $AssignedReductionRate,$description,);
}
