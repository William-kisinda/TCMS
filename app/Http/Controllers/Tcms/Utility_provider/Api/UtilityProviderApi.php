<?php

namespace App\Http\Controllers\Tcms\Utility_provider\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\MeterValidation\Dao\MeterDaoImp;
use App\Http\Controllers\Tcms\MeterValidation\Dao\CustomerDaoImpl;
use App\Http\Controllers\Tcms\MeterValidation\Api\MeterValidateApi;
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

    public function getAllProviders()
    {
        //Validate roles and request information like headers and auth tokens.
        try {
            $providers = $this->utilityProviderDao->getAllUtilityProviders();

            $providersDto = new UtilityProviderDto();
            //Checking if the object has data
            if (!blank($providers)) {
                Log::info("Message::" . json_encode($providers));
                // foreach ($providerCategories as $providerCategory) {
                //     $providerCategory = json_encode($providerCategory, true);
                //     $providerCategoriesArray = $providerCategoriesDto->getProviderCategoryDto($providerCategory['id'], $providerCategory['code'], $providerCategory['name']);
                //     $providerCategoriesDto->setAttributes($providerCategoriesArray);
                // }
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

            //Checking if utility provider exists.
            $providerCode = $request->input('code');
            $providerExists = $this->utilityProviderDao->getUtilityProviderByCode($providerCode);


            //Checking if the object has data
            Log::info("OriginMessage:" . gettype($providerExists));
            if (!blank($providerExists)) {

                    $meterNumber = $request->input('meter_number');
                /**
                 * Now after validating the existance of utility provider , then we use that specific utility providers api to look for their customer information
                 *
                 *
                 */

                 $client = new Client();

                 $response = $client->request('POST', 'http://127.0.0.1:8000/api/meter', [
                     'query' => [
                         'meter_num' => $meterNumber,
                     ],
                 ]);
                 $data = json_decode($response->getBody(), true);

                return Response()->json(["error" => false, "Utility Provider" => $data], Response::HTTP_OK);
            }
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
            $utilityProviderDto = new UtilityProviderDto();
            $utilityProviderDto->setAttributes($request->all());

            // Validate whether such a provider already esists using the name and code.
            $providerExists = $this->utilityProviderDao->getUtilityProviderByCode($utilityProviderDto->getProvider_code());
            Log::info("Log Message:" . json_encode($request->all()));
            if (blank($providerExists)) {
                $provider = $this->utilityProviderDao->createutilityProvider($utilityProviderDto);
                if (!blank($provider)) {
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to create Utility provider']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Utility provider already exists!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
