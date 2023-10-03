<?php

namespace App\Http\Controllers\Tcms\Debts\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Tcms\Debts\Dto\DebtDto;
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
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function assignDebt(Request $request) {
        try {
            Log::info("Log Message:" . json_encode($request->all()));
            $meterId = $request->input('meters_id');
            $debtDto = new DebtDto();
            $debtDto->setAttributes($request->all());

            // Validate whether such a meter_id already exists in the debts table.
            $debtExists = $this->debtDao->getDebtByMeterId($meterId);

            // Log::info("Debt Exists:" . json_encode($debtExists));
            if (blank($debtExists)) {
                $debtInfo = $this->debtDao->assignDebt($debtDto);
                if (!is_null($debtInfo)) {
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to create debt']], Response::HTTP_OK);
            } else {

                //the meter number already assigned with debt.
                $debtInfo = $this->debtDao->assignDebt($debtDto, true);

                if (!is_null($debtInfo)) {
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to update debt']], Response::HTTP_OK);
            }
            // return Response()->json(["error" => false, 'message' => ['Debt already exists!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Debt Exceptional Message::" . $e->getMessage());
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
            $meterNumber = $request->input('meters_id');
            $amount = $request->input('amount');
        ;
            // Call the resolveDebt function from DebtDaoImpl
            $resolve = $this->debtDao->resolveDebt($meterNumber, $amount);

            // Check if the response contains "remainingAmount" and "debtReduction"
            if (array_key_exists('remainingAmount', $resolve)  && array_key_exists('remainingdebt', $resolve) && array_key_exists('debtReduction', $resolve) && $resolve['meterExists']) {


                Log::info("Debts Response: " . json_encode($resolve));

                return Response()->json([
                    "error" => false,
                    "message" => 'Debt resolved successfully!',
                    "remainingAmount" => $resolve['remainingAmount'],
                    "debtReduction" => $resolve['debtReduction'],
                    "remainingdebt" => $resolve['remainingdebt'],
                ], HttpResponse::HTTP_OK);
            }

            return response()->json([
                "error" => true,
                "message" => "Could not fetch debts!",
                "possible reasons : " => "Empty values or meter : " . $meterNumber . " number does not exists"
            ], HttpResponse::HTTP_OK);
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
