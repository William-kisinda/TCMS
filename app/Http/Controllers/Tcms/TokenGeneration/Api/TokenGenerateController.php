<?php
namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\Job\GenerateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpFoundation\Response;

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
        try{
            // Validate meter number (you can call your existing validation API)
            // Dispatch the token generation job to the RabbitMQ queue
            Queue::connection('rabbitmq')->push(new GenerateToken($request->input('amount')));

            // Return a response to the user indicating that the request has been received
            return response()->json(['message' => 'Request Accepted you will receive, token Shortly']);
        }catch (\Exception $exception){
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
