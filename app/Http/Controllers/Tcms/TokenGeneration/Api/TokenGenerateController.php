<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\TokenGeneration\Api\GenerateToken;
use App\Http\Controllers\Tcms\TokenGeneration\Config\Connection;
use Symfony\Component\HttpFoundation\Response;
use PhpAmqpLib\Message\AMQPMessage;

/**
 *
 * @author Julius.
 * this is the token generation api
 *
 * which have two inputs ( amount , MeterInfoDto)
 *
 */

class TokenGenerateController extends Controller
{
    public function produceMessages(Request $request)
    {
        try {
                //Receive Inputs
            $utility_provider = $request->input('utilityProvider');
            $amount = $request->input('amount');
            $meterNumber = $request->input('meterNumber');
            $requestId = $request->input('requestId');
            $requestTime = $request->input('requestTime');
            $partnerCode = $request->input('partnerCode');

             //Log Incoming Request information
             Log::channel('custom_daily')->info("\nThe request for Token generation with the requestId :".$requestId. "\nSuccessful received with the following information :\n Request Header Information : ".json_encode($request->header()). "\nRequest body Information: ".json_encode($request->input()));

            //     // validation
            // if(!isset($utility_provider) || is_null($utility_provider)){
            //     //log error for the invalid input
            //     Log::channel('custom_daily')->info("\nToken Generation Request with request ID : ".$requestId."    User provide Invalid Utility Provider ID which is: ".$utility_provider);
            //     return response()->json(['message' => 'Incorrect information for utility provider.']);
            // }
            // if(is_null($amount) || !is_numeric($amount)){
            //     //log error for the invalid input
            //     Log::channel('custom_daily')->info("\nToken Generation Request with request ID : ".$requestId."    User provide Invalid Amount which is: ".$amount);
            //     return response()->json(['message' => 'Incorrect information for amount.']);
            // }
            // if(is_null($meterNumber) || !is_numeric($meterNumber)){
            //     //log error for the invalid input
            //     Log::channel('custom_daily')->info("\nToken Generation Request with request ID : ".$requestId."    User provide Invalid Meter Number which is : ".$meterNumber);
            //     return response()->json(['message' => 'Incorrect information for meter number.']);
            // }

            $inputs = ["amount" => $amount, "meterNumber" => $meterNumber, "utilityProvider"=>$utility_provider, "requestId" => $requestId, "requestTime" => $requestTime, "partnerCode" => $partnerCode];

            $rabbitConnection = app(Connection::class);
            $channel = $rabbitConnection->getConnectionChannel();

            $msg = new AMQPMessage(json_encode($inputs));

            $channel->basic_publish($msg, 'incoming', 'x');

            $channel->close();
            $rabbitConnection->closeConnection();

                //Log Outgoing Response information
             Log::channel('custom_daily')->info("\nThe Response for Token generation with the requestId :".$requestId. "\nSuccessful Sent to the user, with the following information :\nResponse body Information: ".json_encode($request->input()));

                // Return a response to the user indicating that the request has been received
            return response()->json(['message' => 'Request accepted. you will receive your token shortly.']);
        } catch (\Exception $exception) {

            Log::channel('custom_daily')->error("Exceptional Message::" . $exception->getMessage(). "\nFor the Request with a requestId:".$inputs['requestId']);
            return Response()->json(["error" => true, "message" => 'Failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function consumeMessages()
    {
        try {
            $rabbitConnection = app(Connection::class);
            $channel = $rabbitConnection->getConnectionChannel();

            echo " [*] Waiting for messages. To exit press CTRL+C\n";

            $callback = function ($receivedMsg) {
                $msgArray = json_decode($receivedMsg->body, true);
                Log::channel('custom_daily')->info("\nThe request with an Id: ".$receivedMsg->body.  "Successful received with the consumer with the queue message: ". $receivedMsg->body);

                //Begin processing the message data
                $generateToken = new GenerateToken($msgArray['amount'], $msgArray['meterNumber'], $msgArray['utilityProvider'], $msgArray['requestTime'], $msgArray['partnerCode'], $msgArray['requestId']);
                $generateTokenError = $generateToken->generateToken();
                if($generateTokenError[0]){
                    echo " [x] Request with id ".$generateTokenError[1]." failed"."\n";
                } else {
                    echo " [x] Token generation for Request with id ".$generateTokenError[1]." succefully"."\n";
                }
            };

            $rabbitConnection = app(Connection::class);
            $channel = $rabbitConnection->getConnectionChannel();
            $channel->basic_consume('incomingqueue1', '', false, true, false, false, $callback);

            while ($channel->is_consuming()) {
                $channel->wait();
            }

            $channel->close();
            $rabbitConnection->closeConnection();
        } catch (\Exception $exception) {

           Log::channel('custom_daily')->error("Exceptional Message:" . $exception->getMessage());
        }
    }

}
