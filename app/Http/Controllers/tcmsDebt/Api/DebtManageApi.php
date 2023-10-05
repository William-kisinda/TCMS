<?php

namespace App\Http\Controllers\tcmsDebt\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\tcmsDebt\Dao\DebtDaoImpl;

class DebtManageApi extends Controller
{
    private $debtDao = null;

    public function __construct() {
        $this->debtDao = new DebtDaoImpl();
    }
/**
 *
 * @author Hamphrey Urio.
 *
 */



        public function assignDebt(Request $request)
        {
            try {
                $AssigneDebtAmount= $request->input('AssigneDebtAmount');
                $AssignedReductionRate = $request->input('AssignedReductionRate');
                $meterId=$request->input('meterId');
                $description=$request->input('description');

                // Call the assignDebtByMeterId function with provided parameters
                $response = $this->debtDao->assignDebtByMeterId($meterId, $AssigneDebtAmount, $AssignedReductionRate,$description);

                // Check if the response contains 'meterExists' (indicating success)
                if (isset($response['meterExists']) && $response['meterExists']) {
                    return response()->json([
                        "error" => false,
                        "message" => "Debt assigned successfully!",
                        "debtAmount" => $response['debtAmount'],
                        "debtReduction" => $response['debtReduction'],
                        "description" => $response['description'],
                    ], HttpResponse::HTTP_OK);
                } else {
                    return response()->json([
                        "error" => true,
                        "message" => "Failed to assign debt!",
                    ], HttpResponse::HTTP_BAD_REQUEST);
                }
            } catch (\Exception $e) {
                Log::error("Assign Debt Exception: " . $e->getMessage());
                return response()->json([
                    "error" => true,
                    "message" => "Something went wrong while assigning debt!",
                ], HttpResponse::HTTP_BAD_REQUEST);
            }
        }



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
