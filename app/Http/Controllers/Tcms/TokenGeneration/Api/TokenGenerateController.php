<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\TokenGeneration\Api\GenerateToken;
use App\Http\Controllers\Tcms\TokenGeneration\Config\Connection;
use Symfony\Component\HttpFoundation\Response;
// require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
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
            //Generate RequestId for this Transaction
            $helpers = new Helpers();
            $requestId = $helpers->generateRequestId();

            // validation
            $utility_provider = $request->input('utilityProvider');
            $amount = $request->input('amount');
            $meterNumber = $request->input('meterNumber');
            if(!isset($utility_provider) || is_null($utility_provider)){
                return response()->json(['message' => 'Incorrect information for utility provider.']);
            }
            if(is_null($amount) || !is_numeric($amount)){
                return response()->json(['message' => 'Incorrect information for amount.']);
            }
            if(is_null($meterNumber) || !is_numeric($meterNumber)){
                return response()->json(['message' => 'Incorrect information for meter number.']);
            }

            $inputs = ["amount" => $amount, "meterNum" => $meterNumber, "utility_provider"=>$utility_provider, "requestId" => $requestId];
            
            $rabbitConnection = new Connection();
            $channel = $rabbitConnection->getConnectionChannel();

            $msg = new AMQPMessage(json_encode($inputs));
            //$channel->basic_publish($msg, '', 'tokenGen');  //Publish to queue

            $channel->basic_publish($msg, 'incoming', 'x');

            $channel->close();
            $rabbitConnection->closeConnection();

            // Return a response to the user indicating that the request has been received
            return response()->json(['message' => 'Request accepted. you will receive your token shortly.']);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => 'Failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function consumeMessages()
    {
        try {
            $rabbitConnection = new Connection();
            $channel = $rabbitConnection->getConnectionChannel();

            echo " [*] Waiting for messages. To exit press CTRL+C\n";

            $callback = function ($receivedMsg) {
                $msgArray = json_decode($receivedMsg->body, true);
                Log::info("Recieved Inputs::" . json_encode($msgArray));

                //Begin processing the message data
                $generateToken = new GenerateToken($msgArray['amount'], $msgArray['meterNum'], $msgArray['requestId'], $msgArray['utility_provider']);
                $generateTokenError = $generateToken->generateToken();
                if($generateTokenError[0]){
                    echo " [x] Request with id ".$generateTokenError[1]." failed"."\n";
                } else {
                    echo " [x] Token generation for Request with id ".$generateTokenError[1]." succefully"."\n";
                }
            };

            $rabbitConnection = new Connection();
            $channel = $rabbitConnection->getConnectionChannel();
            $channel->basic_consume('incomingqueue1', '', false, true, false, false, $callback);

            while ($channel->is_consuming()) {
                $channel->wait();
            }

            $channel->close();
            $rabbitConnection->closeConnection();
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
        }
    }
}
