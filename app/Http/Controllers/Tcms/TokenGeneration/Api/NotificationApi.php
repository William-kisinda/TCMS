<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDaoImp;

/**
 * This Class for fetching notification
 * @author Julius.
 * Email: juliusstephen1@gmail.com
 *
 */

 class NotificationApi extends Controller
 {
     private $tokenManageDao;

     public function __construct(TokenManageDaoImp $partnerDao)
     {
        $this->tokenManageDao = $partnerDao;
     }


 /**
  * This is the method fething only today token
  * @author Julius.
  * Email: juliusstephen1@gmail.com
  *
  */

     public function todayTokens(Request $request)
     {
         try {
              //Log received Request information
              Log::channel('meter_validation')->info("\nThe request for Validating Meter Number with the requestId :".$request->input('requestId'). "\nSuccessful received with the following information :\n Request Header Information : ".json_encode($request->header()). "\nRequest body Information: ".json_encode($request->input()));

              //Validate received Inputs
              $validatedInputs = $request->validate([
                 'partnerCode' => ['required','alpha_num:ascii'],
              ]);

               // Retrieve validated request information
             $partnerCode = $validatedInputs['partnerCode'];

             // Retrieve today Notifications.
             $notifications = $this->tokenManageDao->getNotificationByPartnerCodeTodaysDate($partnerCode);

             if ($notifications) {

                 //Log send Response information
                Log::channel('token_fetch')->info("\nTokens Fetched Succesful with the information :".json_encode($notifications));

                return response()->json(['notifications' => $notifications], Response::HTTP_OK);

         }else{
            //  $response = $this->meterDto->responseErrorDto($requestId,ErrorCode::METERNUMBER_ERROR['code'], ErrorCode::METERNUMBER_ERROR['description'],"Meter does Not exist", $requestTime, Date::now());
            //      //Log Response Error
             Log::channel('token_fetch')->info("\nNo information found about the pertner Code Given");

             return response()->json(['message'=>"No information found about the pertner Code Given"], Response::HTTP_NOT_FOUND);
         }
         }
         catch (\Illuminate\Validation\ValidationException $e) {

                 //Log Response Error
             Log::channel('token_fetch')->error("\nInvalid Inputs");
             return response()->json(['message'=>$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
         }catch (\Exception $exception) {
             //Log Response Error
             Log::channel('token_fetch')->error("\nServer Problem");
             return response()->json(['message'=>$exception->getMessage()] , Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }
 }
