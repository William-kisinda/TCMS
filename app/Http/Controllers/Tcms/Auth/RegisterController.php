<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * General method to return success response
     * @return JsonResponse
     */
    public function sendResponse($result, $message)
    {
        return response()->json([
            "success" => true,
            "message" => $message,
            "data" => $result
        ], 200);
    }
    /**
     * Register Api
     * 
     * @param Request $request
     * @return Response
     */
    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "phone" => "required|max:10|min:10",
            "password" => "required",
            "confirm_password" => "required|same:password"
        ]);

        if ($validator->fails()) {
            return $this->sendError("Validation Error", $validator->errors());
        }
    }
}
