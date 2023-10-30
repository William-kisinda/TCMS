<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use Illuminate\Http\Request;
use App\Models\Notifications;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDaoImp;

class NotificationApi extends Controller
{
    protected $meterDao;
    protected $tokeManageDao;

    public function __construct(MeterDaoImpl $meterDao, TokenManageDaoImp $tokenManageDao) {
        $this->meterDao = $meterDao;
        $this->tokeManageDao = $tokenManageDao;
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

        try {
            if(!isset($requestId) || is_null($requestId)){
                return response()->json(['message' => 'Incorrect information for Request ID.']);
            }
            if(is_null($meterNumber) || !is_numeric($meterNumber)){
                return response()->json(['message' => 'Incorrect information for Meter Number.']);
            }
            //fetch meter information
            $meter = $this->meterDao->checkIfMeterExists($meterNumber);
            $tokenInfo = $this->tokeManageDao->getNotificationByRequestIdMeterNumber($meter->getMeterId(),$requestId);

            //Log Notification Information
            Log::channel('daily')->info('\nThis request with id: ' . json_encode(['request_id' => $requestId]) . ' Notification is successful send to the User with the below Notification body:\n'.json_encode($tokenInfo));

            return response()->json(["error" => false, "Meter Information" => $tokenInfo->getAttributes()], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::channel('daily')->error("\nThe request with ID ".$requestId."Have Error with Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
