<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\Helpers;
use App\Job\GenerateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
    public function generateToken(Request $request)
    {
        try {
            //Generate RequestId for this Transaction
            $helpers = new Helpers();
            $requestId = $helpers->generateRequestId();



            // validation
            // {"utilityProvider": "", "amount": 10000, "meterNumber": 259614371212}

            $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
            $channel = $connection->channel();

            // $channel->queue_declare('hello', false, false, false, false);

            $msg = new AMQPMessage($request);
            //$channel->basic_publish($msg, '', 'tokenGen');  //Publish to queue

            $channel->basic_publish($msg, 'incoming', 'x');

            // $channel->close();
            // $connection->close();

            // echo " [x] Sent 'Hello World!'\n";
            Log::info("Sent Inputs::" . $request);




            // Dispatch the token generation job to the RabbitMQ queue
            //GenerateToken::dispatch($request->input('amount'), $request->input('meterNumber'), $requestId, $request->input('tariffs'))->onQueue('tokenGen');

            $callback = function ($receivedMsg) {
                Log::info("Inputs::" . $receivedMsg->body);
                Log::info("Inputs::xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
            };

            $channel->basic_consume('tokenGen', '', false, true, false, false, $callback);

            // if($channel->is_open()) { 
            //     $channel->wait();
            // }

            $channel->close();
            $connection->close();

            // Return a response to the user indicating that the request has been received
            return response()->json(['message' => 'Request Accepted you will receive, token Shortly']);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
