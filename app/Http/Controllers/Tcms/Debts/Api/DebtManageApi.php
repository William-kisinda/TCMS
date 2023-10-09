<?php

namespace App\Http\Controllers\Tcms\Debts\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Tcms\Debts\Dao\DebtDaoImpl;

class DebtManageApi extends Controller
{
    private $debtDao = null;

    public function __construct() {
        $this->debtDao = new DebtDaoImpl();
    }

    /*
     * Create a Debt.
     *
     * @param
     * @return \Illuminate\Http\JsonResponse
    */
    public function assignDebt(Request $request) {
        try {
            $debtInfo = $this->debtDao->assignDebtByMeterId($request->meters_id, $request->amount, $request->reductionRate,  $request->description);
            if (!is_null($debtInfo)) {
                return Response()->json(["error" => false, 'debtInfo' => $debtInfo], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Failed to assign debt']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error("Debt Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /*
     * Resolve Debt.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function resolve(Request $request)
{
    try {
        return Response()->json( $this->debtDao->resolveDebt($request->meterId, $request->amount), HttpResponse::HTTP_OK);

    } catch (\Exception $e) {
        Log::info("Debts Exception: " . $e->getMessage());
        return response()->json([
            "error" => true,
            "Debts Exception: " . $e->getMessage(),
            "message" => "Something went wrong!",
        ], HttpResponse::HTTP_BAD_REQUEST);
    }
}


public function getDebtByMeterId(Request $request)
{
    try {
       $meterId = $request->input('meterId');

        // Call the getDebtByMeterId function from your Dao or Repository
        $debt = $this->debtDao->getDebtByMeterId($meterId);

        if (!blank($debt)) {
            return response()->json([
                "error" => false,
                "debt" => $debt,
            ], HttpResponse::HTTP_OK);
        } else {
            return response()->json([
                "error" => true,
                "message" => "meter does not exist",
            ], HttpResponse::HTTP_NOT_FOUND);
        }
    } catch (\Exception $e) {
        Log::error("Debt Exception: " . $e->getMessage());
        return response()->json([
            "error" => true,
            "Debts Exception: " . $e->getMessage(),
            "message" => "Something went wrong!",
        ], HttpResponse::HTTP_BAD_REQUEST);
    }
}


}
