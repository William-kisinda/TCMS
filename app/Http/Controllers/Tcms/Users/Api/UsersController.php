<?php

namespace App\Http\Controllers\Tcms\Users\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\UtilityProviderModel;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
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
            $user = new User;
            $utilityProviderId = $request->input('utility_provider_id');
            if(!is_null($utilityProviderId)){
                $utilityProvider = UtilityProviderModel::find($utilityProviderId);
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->phone_number = $request->input('phone_number');
                $user->password = $request->input('password');
                $user->utility_provider_model_id = $utilityProviderId;
                $user->utility_provider()->associate($utilityProvider)->save();
            } else {
                $user = User::create($input);
            }
            $user->assignRole($request->input('roles'));
            if (!blank($user)) {
                return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Failed to create user!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Create User Exceptional Message::" . $e->getMessage());
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

            $users = User::get();
            $usersArray = array();

            if (!blank($users)) {
                foreach($users as $key => $user){
                    $userData = ['id' => $user->id, 'full_name' => $user->full_name, 'email' => $user->email, 'phone_number' => $user->phone_number, 'roles' => $user->getRoleNames()];
                    array_push($usersArray, $userData);
                }
                return Response()->json(["error" => false, 'users' => $usersArray], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'users' => $users], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get user By Id
     * 
     * @param Request $request
     * @return Response
     */
    public function getUPUserById(Request $request)
    {
        $userId = $request->input('userId');
        $user = [];
        try {

            $user = User::find($userId);

            Log::info("User::" . json_encode($user));
            
            if (!blank($user)) {
                $uprovider = $user->utility_provider;
                $user = ['id' => $user->id, 'full_name' => $user->full_name, 'email' => $user->email, 'phone_number' => $user->phone_number, 'utility_provider_id' => $user->utility_provider_id, 'utility_provider'=> isset($uprovider->provider_name) ? $uprovider->provider_name : "None", 'roles' => $user->getRoleNames()];
                Log::info("Users Full Data::" . json_encode($user));
                return Response()->json(["error" => false, 'user' => $user], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'user' => $user], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Update User
     * 
     * @param Request $request
     * @return Response
     */
    public function updateUPUser(Request $request)
    {
        $userId = $request->input('id');
        try {

            $user = User::find($userId);
            $user->utility_provider_model_id = $request->input('utility_provider_id');
            $user->update($request->all());
            DB::table('model_has_roles')->where('model_id', $userId)->delete(); //We delete previously assigned roles ready to save new roles updated.

            $user->assignRole($request->input('roles'));

            if (!blank($user)) {
                return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Failed to create user!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Update User Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
