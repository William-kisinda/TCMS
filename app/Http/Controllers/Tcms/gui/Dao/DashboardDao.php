<?php

namespace App\Http\Controllers\Tcms\gui\Dao;


/**
 *Dashboard Data access Object.
 * @author Julius.
 *
 * @param null
 * @return \Illuminate\Http\JsonResponse
 */

 interface DashboardDao
 {
      public function numberOfUtilityProviders();
      public function numberOfCustomers();
      public function numberOfProviderCategory();
      public function latestCustomers();
      public function latestUtilityProviders();
      public function numberOfTokens();
      public function totalDebtAmount();
     // public function weeklyData();
 }
