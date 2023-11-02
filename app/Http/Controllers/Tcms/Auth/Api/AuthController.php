<?php

namespace App\Http\Controllers\Tcms\Auth\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\UtilityProviderModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Tcms\Utility_provider\Dao\UtilityProviderDaoImpl;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $utilityProviderDao;

    public function __construct()
    {
        $this->utilityProviderDao = new UtilityProviderDaoImpl(new UtilityProviderModel());
    }
    /*
     * Authenticate a User.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|string',
            'password' => 'required'
        ]);

        $credentials = $request->all();

        if (!Auth::attempt($credentials)) {
            return Response()->json(["error" => true, 'message' => 'Incorrect credentials!Try again.'], Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        $user_utility_provider = $user->utility_provider;
        $roles = $user->getRoleNames();
        $permissions = collect(Auth::user()->getAllPermissions())->pluck('name')->toArray();
        $utilityProvider = "None";

        if (isset($user_utility_provider->provider_name)) {
            $utilityProvider = $user_utility_provider->provider_name;
        }
        return Response()->json(["error" => false, 'data' => ['user' => $user, 'token' => $token, 'utility_provider' => $utilityProvider, 'roles' => $roles, 'permissions' => $permissions]], Response::HTTP_OK);
    }

    /*
     * Logout a User.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return Response()->json(["error" => false, 'success' => true], Response::HTTP_OK);
    }
}
