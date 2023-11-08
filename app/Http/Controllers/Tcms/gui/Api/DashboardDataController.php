<?php

namespace App\Http\Controllers\Tcms\gui\Api;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\gui\Dao\DashboardDaoImpl;


class DashboardDataController extends Controller
{
    protected $dashboardDao;

    public function __construct(DashboardDaoImpl $dashboardDao) {
        $this->dashboardDao = $dashboardDao;
    }

/**
 * API that return Dashboard Information(summary Information).
 * @author Julius.
 *
 * @param null
 * @return \Illuminate\Http\JsonResponse
 */

    public function dashboardData()
    {
          //Received request for data fetching information
          Log::channel('custom_daily')->info("\n Retrieving data from the database for display it on the dashboard: ");

         try {
             //fetch Data in the Database
            $fullData = [
                'customersNo' => $this->dashboardDao->numberOfCustomers(),
                'providerCategoryNo'=> $this->dashboardDao->numberOfProviderCategory(),
                'utilityProviderNo' => $this->dashboardDao->numberOfUtilityProviders(),
                'customersList' => $this->dashboardDao->latestCustomers(),
                'utilityProviderList' => $this->dashboardDao->latestUtilityProviders(),
                'numberOfTokens' => $this->dashboardDao->numberOfTokens(),
                'totalDebtAmount' => $this->dashboardDao->totalDebtAmount()
            ];

            //Log Data fetching status
            Log::channel('daily')->info('\n Data was successful Fethed from the Database And returned to the frontEnd, Serving the request for accesing data in the Database');

            return response()->json(["error" => false, "Full Fetched data" => $fullData], Response::HTTP_OK);
         } catch (\Exception $exception) {
            Log::channel('custom_daily')->error('\n Fetching Data Failed due to  :'. $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Fetching Data Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
    }

}
