<?php

namespace App\Http\Controllers\Tcms\gui\Dao;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UtilityProviderModel;
use App\Http\Controllers\Tcms\gui\Dao\DashboardDao;

/**
 * Dashboard Data Access Object Implementation.
 * @author Julius.
 *
 * @param null
 * @return \Illuminate\Http\JsonResponse
 *
 */

class DashboardDaoImpl implements DashboardDao{
    protected $utilityProvider;
    protected $customer;

    public function __construct(UtilityProviderModel $utilityProvider, Customer $customer) {
        $this->utilityProvider = $utilityProvider;
        $this->customer = $customer;
    }

    public function numberOfUtilityProviders()
    {
        try {
            $count = DB::table('utility_providers')->count();
            return $count;
        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error("\nError while counting utility providers: ". [$exception->getMessage()]);
            return $exception->getMessage();
        }
    }

    public function numberOfCustomers()
    {
        try {
            $count = DB::table('customers')->count();
            return $count;
        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error("\nError while counting Customers: ". [$exception->getMessage()]);
            return $exception->getMessage();
        }
    }

    public function numberOfProviderCategory()
    {
        try {
            $count = DB::table('provider_categories')->count();
            return $count;
        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error("\nError while counting Provider Categories: ". [$exception->getMessage()]);
            return $exception->getMessage();
        }
    }

    public function latestCustomers()
    {
        try {
            $customers = DB::table('customers')->orderBy('id', 'desc')->take(5)->get();

            return $customers;

        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error("\nError while Fetching Customer List in the Database: ". [$exception->getMessage()]);
            return $exception->getMessage();
        }
    }

    public function latestUtilityProviders()
    {
        try {
            $utilityProviders = DB::table('utility_providers')->orderBy('id', 'desc')->take(5)->get();

             return $utilityProviders;

        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error("\nError while Fetching Utility Providers List in the Database: ". [$exception->getMessage()]);
            return $exception->getMessage();
        }
    }

    public function numberOfTokens()
    {
        try {
            $numberOfTokens = DB::table('debts')->sum('remainingDebtAmount');

            return $numberOfTokens;

        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error("\nError while Fetching number of Tokens in the Database: ". [$exception->getMessage()]);
            return $exception->getMessage();
        }
    }

    public function totalDebtAmount()
    {
        try {
            $totalDebtAmount = DB::table('token_manage')->count();

             return $totalDebtAmount;

        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error("\nError while Fetching total Debt Amount in the Database: ". [$exception->getMessage()]);
            return $exception->getMessage();
        }
    }

}
