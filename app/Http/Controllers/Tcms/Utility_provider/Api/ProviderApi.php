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

class ProviderApi extends Controller
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
            $providers = $this->utilityProviderDao->getAllProviders();

            $providersDto = new UtilityProviderDto();
            //Checking if the object has data
            if (!blank($providers)) {
                Log::info("Exceptional Message::" . json_encode($providers));
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
            //retrieve utility provider code from input
            $providerCode = $request->input('code');
            $meterNumber = $request-> input('meter_number');

            //Checking if provider category exists.
            $providerExists = $this->utilityProviderDao->getProviderByCode($providerCode);

            $utilityProviderDto = new UtilityProviderDto();
            //Checking if the object has data
            Log::info("OriginMessage:" . gettype($providerExists));
            if (!blank($providerExists)) {
                 Log::info("Exceptional Message::" . json_encode($providerExists));

/*                //Using the DTO to get and set object data properties.
                $providerArray = $utilityProviderDto->setProviderDto(
                    $providerExists->getProviderId(),
                    $providerExists->getProviderCode(),
                    $providerExists->getProviderName(),
                    $providerExists->getProviderStatus(),
                    $providerExists->getProviderCategoriesCode(),
                );

                //Now setting the provider categories array attributes.
                $utilityProviderDto->setAttributes($providerArray);
*/

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

                return Response()->json(["error" => false, "Meter information" => $data], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "Utility Providers" => ['Invalid Provider code']], Response::HTTP_NOT_FOUND);
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
   /* public function createProvider(Request $request)
    {
        try {
          //  $providerDto = new UtilityProviderDto();
          //  $providerDto->setAttributes($request->all());

            //Validate whether such a category already esists using the name and code.
         //   $providerExists = $this->Dao->getProviderCategoryByNameOrCode($providerDto->getProv_categ_name(), $providerDto->getProv_categ_code());
            Log::info("Log Message:" . json_encode($request->all()));
            if (blank($providerExists)) {
                $provider = $this->Dao->createProvider($providerDto);
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
    }*/
}
