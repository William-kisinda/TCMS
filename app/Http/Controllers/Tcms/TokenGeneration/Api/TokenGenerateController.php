<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\ErrorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Tcms\TokenGeneration\Api\GenerateToken;
use App\Http\Controllers\Tcms\TokenGeneration\Config\Connection;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;
use App\Http\Controllers\Tcms\Utility_provider\Dao\UtilityProviderDaoImpl;

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

/**
 * This is the controller that receive token purchase request and push the request data to the queue for being processed
 * @author Julius.
 * Email: juliusstephen1@gmail.com
 *
 */
    public function produceMessages(Request $request)
    {
        try {
                //Log received Request information
            Log::channel('token_purchase')->info("\nThe Request for Token Purchase with the requestId :".$request->input('requestId'). "\nSuccessful received with the following information :\n Request Header Information : ".json_encode($request->header()). "\nRequest body Information: ".json_encode($request->input()));

                //Validate received Inputs
            $validatedInputs = $request->validate([
            'meterNumber' => ['required','numeric','digits:12'],
            'utilityProvider' => ['required','numeric'],
            'requestId' => ['required','numeric'],
            'partnerCode' => ['required','alpha_num:ascii'],
            'requestTime' => ['required', 'date_format:Y-m-d H:i:s', 'before_or_equal:' . Date::now()],
            'amount' => ['required', 'numeric', 'min: 0', 'max: 2000000', 'regex:/^\d+(\.\d{1,2})?$/']
            ]);

                // Retrieve information from the validated request payload
            $meterNumber = $validatedInputs['meterNumber'];
            $utilityProvider = $validatedInputs['utilityProvider'];
            $requestId = $validatedInputs['requestId'];
            $partnerCode = $validatedInputs['partnerCode'];
            $requestTime = $validatedInputs['requestTime'];
            $amount = $validatedInputs['amount'];

            $inputs = ["amount" => $amount, "meterNumber" => $meterNumber, "utilityProvider"=>$utilityProvider, "requestId" => $requestId, "requestTime" => $requestTime, "partnerCode" => $partnerCode];

            $rabbitConnection = app(Connection::class);
            $channel = $rabbitConnection->getConnectionChannel();
            $msg = new AMQPMessage(json_encode($inputs));
            $channel->basic_publish($msg, 'incoming', 'x');
            $channel->close();
            $rabbitConnection->closeConnection();

            //set Data to the Response DTO
            $utilityProviderDao = app(UtilityProviderDaoImpl::class);
            $utilityProvider = $utilityProviderDao->getUtilityProviderById($utilityProvider);
            $message = "Your Request is Successful Received Will Receive your token shortly";
            $tokenDto  = app(TokenManageDto::class);
            $response = $tokenDto->ackResponse($meterNumber, $utilityProvider->getUtilityProviderName(), $requestId, $requestTime, $partnerCode, Date::now(), $message);

                 //Log send Response information
            Log::channel('token_purchase')->info("\nToken Purchase Acknowledgement for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($response));

                // Return a response to the user indicating that the request has been received
            return response()->json(['message' => 'Request accepted']);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $requestId = $request->input('requestId');
            // If validation fails, Laravel throws a ValidationException. Errors can be retrieved as follows
            $validationErrors = $e->validator->errors()->all();
            $response = $tokenDto->responseErrorDto($requestId,ErrorCode::INVALID_INPUT['code'], ErrorCode::INVALID_INPUT['description'], $validationErrors, $requestTime, Date::now());

                //Log Response Error
            Log::channel('token_purchase')->error("\nToken Purchase Response for the request with the requestId :".$requestId. "\nSuccessful send to the user with the following information : ".json_encode($response));
            return response()->json(["error" => true, "message" => $response], Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch (\Exception $exception) {
            $requestId = $request->input('requestId');
            $response = $tokenDto->responseErrorDto($requestId,ErrorCode::SERVER_ERROR['code'], ErrorCode::SERVER_ERROR['description'],$exception->getMessage(),$requestTime,Date::now());
            //Log Response Error
            Log::channel('token_purchase')->error("\nMeter Validation Response for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($response));
            return response()->json(["error" => true, "message" =>  $response], Response::HTTP_INTERNAL_SERVER_ERROR);
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

         Log::error("Exceptional Message:" . $exception->getMessage());
        }
    }

}
