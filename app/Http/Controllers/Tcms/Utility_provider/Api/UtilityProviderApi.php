<?php
namespace App\Http\Controllers\Tcms\Utility_provider\Api;

use App\Helpers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\Utility_provider\Dto\UtilityProviderDto;
use App\Http\Controllers\Tcms\Utility_provider\Dao\UtilityProviderDaoImpl;

class UtilityProviderApi extends Controller
{
    private $utilityProviderDao = null;

    public function __construct()
    {
        $this->utilityProviderDao = new UtilityProviderDaoImpl();
    }

    /**
     * Display a listing of of all utility providers.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAllProviders(Request $request)
    {
        //Validate roles and request information like headers and auth tokens.
        try {
            $providers = $this->utilityProviderDao->getAllUtilityProviders();

            $providersDto = new UtilityProviderDto();
            //Checking if the object has data
            if (!blank($providers)) {
                Log::info("Message::" . json_encode($providers));
                return Response()->json(["error" => false, "providers" => $providers], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "providers" => $providersDto->getAttributes()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display a listing of of all utility providers.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

     public function getAllProvidersWithNoUsers(Request $request)
     {
         //Validate roles and request information like headers and auth tokens.
         try {
             $providers = $this->utilityProviderDao->getAllUtilityProvidersWithNoUsers();
 
             $providersDto = new UtilityProviderDto();
             //Checking if the object has data
             if (!blank($providers)) {
                 Log::info("Message::" . json_encode($providers));
                 return Response()->json(["error" => false, "providers" => $providers], Response::HTTP_OK);
             }
             return Response()->json(["error" => false, "providers" => $providersDto->getAttributes()], Response::HTTP_BAD_REQUEST);
         } catch (\Exception $exception) {
             Log::info("Exceptional Message::" . $exception->getMessage());
             return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }

    /**
     * Get provider utility provider by their code.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProviderByCode(Request $request)
    {
        try {

            $providerCode = $request->input('providerCode');
            //Checking if utility provider exists.
            // $providerCode = $request->input('code');
            $providerExists = $this->utilityProviderDao->getUtilityProviderByCode($providerCode);
            $helpers = new Helpers();
            $requestId = $helpers->generateRequestId();

            //Checking if the object has data
            Log::info("OriginMessage:" . $providerExists);
            if (!blank($providerExists)) {

                $utilityProviderDto = new UtilityProviderDto();
                $utilityProviderDto->setAttributes($providerExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Utility Provider" => $utilityProviderDto->getAttributes()], Response::HTTP_OK);
            }

            //Logging
            Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is Failed to be  processed due to Invalid Utitlity provider Code');

            return Response()->json(["error" => false, "Utility Provider" => ['Invalid Utility Provider Code']], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Get provider utility provider by their id.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProviderById(Request $request)
    {
        try {

            $providerId = $request->input('providerId');
            $providerExists = $this->utilityProviderDao->getUtilityProviderById($providerId);
            $helpers = new Helpers();
            $requestId = $helpers->generateRequestId();

            //Checking if the object has data
            if (!blank($providerExists)) {

                $utilityProviderDto = new UtilityProviderDto();
                $utilityProviderDto->setAttributes($providerExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Utility Provider" => $utilityProviderDto->getAttributes()], Response::HTTP_OK);
            }

            //Logging
            Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is Failed to be  processed due to Invalid Utitlity provider Code');

            return Response()->json(["error" => false, "Utility Provider" => ['Invalid Utility Provider Code']], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /*
     * Create a Utility Provider.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function createUtilityProvider(Request $request)
    {
        try {
            //take all the inputs and store them.
            $inputs = $request->all();

            //generate code as per the context name
            $helper = new Helpers();
            $provider_code = $helper->generateCode($inputs['provider_name']);
            $inputs = array_merge($inputs, ['provider_status' => 'Active', 'provider_code' => $provider_code]);

            //Transfer into DTO
            $utilityProviderDto = new UtilityProviderDto();
            $utilityProviderDto->setAttributes($inputs);

            // Validate whether such a provider already exists using the name and code.
            $providerExists = $this->utilityProviderDao->getUtilityProviderByNameOrCode($utilityProviderDto->getProvider_name(), $utilityProviderDto->getProvider_code());
            if (blank($providerExists)) {
                $provider = $this->utilityProviderDao->createutilityProvider($utilityProviderDto);
                if (!blank($provider)) {
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to create Utility Provider']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Utility provider already exists!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /*
     * Update a Utility Provider.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function updateUtilityProvider(Request $request)
    {
        try {
            //take all the inputs and store them.
            $inputs = $request->all();

            Log::info("Update Utility Provider Request::" . json_encode($inputs));
            //Transfer into DTO
            $utilityProviderDto = new UtilityProviderDto();
            $utilityProviderDto->setAttributes($inputs);

            $utilityProvider = $this->utilityProviderDao->updateUtilityProvider($utilityProviderDto);
            if (!blank($utilityProvider)) {
                return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Failed to update utility provider.']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Update Utility Provider Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
