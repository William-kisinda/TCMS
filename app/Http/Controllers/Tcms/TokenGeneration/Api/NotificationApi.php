<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use Illuminate\Http\Request;
use App\Models\Notifications;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDaoImp;
use Exception;

class NotificationApi extends Controller
{
    protected $meterDao;
    protected $tokenManageDao;

    public function __construct(MeterDaoImpl $meterDao, TokenManageDaoImp $tokenManageDao) {
        $this->meterDao = $meterDao;
        $this->tokenManageDao = $tokenManageDao;
    }

    /**
     * User Api , for fetching tokens n send it to the users .
     * @author Julius.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendNotification(Request $request)
    {
        $requestId = $request->input('requestId');
        $meterNumber = $request->input('meterNumber');

        //Received request information
        Log::channel('custom_daily')->info("\n Notification Accessing Request in the Database with Request ID: ".$requestId."  Sucessful Received! \n With the Information : ".json_encode($request->input()));

        try {
            if(!$requestId){
                //log error for the invalid input
                Log::channel('custom_daily')->info("\n Notification Accessing Request with request ID : ".$requestId."    User provide Invalid requestID which is: ".$requestId);
                return response()->json(['message' => 'Incorrect information for Request ID.']);
            }
            if(!$meterNumber){
                 //log error for the invalid input
                 Log::channel('custom_daily')->info("\nNotification Accessing Request with request ID : ".$requestId."    User provide Invalid Meter Number which is: ".$meterNumber);
                return response()->json(['message' => 'Incorrect information for Meter Number.']);
            }
            //fetch meter information
            $meterId = $this->meterDao->checkIfMeterExists($meterNumber,)->getMeterId();
            $tokenInfo = $this->tokenManageDao->getNotificationByRequestIdMeterNumber($meterId,$requestId);

            //Log Notification Information
            Log::channel('custom_daily')->info('\nNotification Accessing Response, For the Request with the RequestId: ' . json_encode(['request_id' => $requestId]) . ' Send Successsful with Notification body:\n'.json_encode($tokenInfo));

            return response()->json(["error" => false, "Meter Information" => $tokenInfo->getAttributes()], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::channel('custom_daily')->error('\nNotification Accessing Response, For the Request with the RequestId: ' . json_encode(['request_id' => $requestId]). "  Send Failed due to the Error : ".$exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
