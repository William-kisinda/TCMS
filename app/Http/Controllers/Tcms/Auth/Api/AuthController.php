<?php

namespace App\Http\Controllers\Tcms\Auth\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
     * Create a Utility Provider User.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function createUPUser(Request $request)
    {
        try {
            Log::info("Log Message:" . json_encode($request->all()));
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);
            $user->assignRole($request->input('roles'));
            if (!blank($user)) {
                return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Failed to create user!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Get all users
     * 
     * @param Request $request
     * @return Response
     */
    public function getUPUsers(Request $request)
    {
        $users = [];
        try {

            $users =User::all();

            if (!blank($users)) {
                return Response()->json(["error" => false, 'users' => $users], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'users' => $users], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
