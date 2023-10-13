<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class ApiEngine extends Controller
{

    /**
     * User Api , for receiving tokens.
     * @author Julius.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function tokenReceiver(Request $request)
    {
        //Validate roles and request information like headers and auth tokens.
        $token = $request->input('token');

        try {
            if (!blank($token)) {
                Log::info("Received token:" . json_encode($token));
                return Response()->json(["error" => false, "your token" => $token], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "your token" => "just errors"], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * User Api , for receiving tokens.
     * @author Julius.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

     public function tokenNotifications(Request $request)
     {
         //Validate roles and request information like headers and auth tokens.
         try {
            $notifications = Notifications::latest()->get();
            Log::info("notifications:" . json_encode($notifications));
            return Response()->json(["error" => false, "notifications" => $notifications], Response::HTTP_OK);
         } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "notifications" => []], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }
}
