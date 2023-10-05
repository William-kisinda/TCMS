<?php
namespace App\Http\Controllers\Tcms\TariffsManagement\Api;

use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\TariffsManagement\Dao\TariffsDaoImpl;
use App\Http\Controllers\Tcms\TariffsManagement\Dto\TariffsDto;

class TariffsApi extends Controller
{
    private $tariffsDao = null;


    public function __construct()
    {
        $this->tariffsDao = new TariffsDaoImpl();
    }

    /**
     * Display a listing of of all tariffs.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */


    public function getAllTariffs(Request $request)
    {
        //Validate roles and request information like headers and auth tokens.
        try {
            $tariffs = $this->tariffsDao->getAllTariffs();

            $tariffsDto = new TariffsDto();
            //Checking if the object has data
            if (!blank($tariffs)) {
                Log::info("Message::" . json_encode($tariffs));

                return Response()->json(["error" => false, "tariffs" => $tariffs], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "tariffs" => ["Couldn't fetch tariffs."]], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get tariff by their id.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function getTariffById(Request $request)
    {
        try {

            $tariffId = $request->input('id');
            //Checking if tariffs exists.
            $tariffExists = $this->tariffsDao->getTariffById($tariffId);
            $helpers = new Helpers();
            $requestId = $helpers->generateRequestId();

            //Checking if the object has data
            Log::info("OriginMessage:" . $tariffExists);
            if (!blank($tariffExists)) {

                $tariffDto = new TariffsDto();

                $tariffDto->setAttributes($tariffExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Tariff" => $tariffDto->getAttributes()], Response::HTTP_OK);
            }
            
            //Logging
            Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' failed due to Invalid Tariff Id.');

            return Response()->json(["error" => false, "Tariff" => ['Invalid Tariff Id']], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::info("Tariff Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get tariff by their name.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

     public function getTariffByName(Request $request)
     {
         try {
 
             $tariffName = $request->input('name');
             //Checking if tariffs exists.
             $tariffExists = $this->tariffsDao->getTariffByName($tariffName);
             $helpers = new Helpers();
             $requestId = $helpers->generateRequestId();
 
             //Checking if the object has data
             Log::info("OriginMessage:" . $tariffExists);
             if (!blank($tariffExists)) {
 
                 $tariffDto = new TariffsDto();
 
                 // $utilityProviderDto->getProiv
                 $tariffDto->setAttributes($tariffExists);
 
                 //logging
                 Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');
 
                 return Response()->json(["error" => false, "Tariff" => $tariffDto->getAttributes()], Response::HTTP_OK);
             }
             
             //Logging
             Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' failed due to Invalid Tariff Id.');
 
             return Response()->json(["error" => false, "Tariff" => ['Invalid Tariff Name']], Response::HTTP_NOT_FOUND);
         } catch (\Exception $exception) {
             Log::info("Tariff Exceptional Message::" . $exception->getMessage());
             return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }

     /**
     * Get tariff by their code.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

     public function getTariffByCode(Request $request)
     {
         try {
 
             $tariffCode = $request->input('code');
             //Checking if tariffs exists.
             $tariffExists = $this->tariffsDao->getTariffByCode($tariffCode);
             $helpers = new Helpers();
             $requestId = $helpers->generateRequestId();
 
             //Checking if the object has data
             Log::info("OriginMessage:" . $tariffExists);
             if (!blank($tariffExists)) {
 
                 $tariffDto = new TariffsDto();
 
                 // $utilityProviderDto->getProiv
                 $tariffDto->setAttributes($tariffExists);
 
                 //logging
                 Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');
 
                 return Response()->json(["error" => false, "Tariff" => $tariffDto->getAttributes()], Response::HTTP_OK);
             }
             
             //Logging
             Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' failed due to Invalid Tariff Id.');
 
             return Response()->json(["error" => false, "Tariff" => ['Invalid Tariff Code']], Response::HTTP_NOT_FOUND);
         } catch (\Exception $exception) {
             Log::info("Tariff Exceptional Message::" . $exception->getMessage());
             return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }

     /**
     * Get tariff by their name, code.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

     public function getTariffByNameOrCode(Request $request)
     {
         try {
 
             $tariffName = $request->input('name');
             $tariffCode = $request->input('code');

             //Checking if tariffs exists.
             $tariffExists = $this->tariffsDao->getTariffByNameOrCode($tariffName, $tariffCode);
             $helpers = new Helpers();
             $requestId = $helpers->generateRequestId();
 
             //Checking if the object has data
             Log::info("OriginMessage:" . $tariffExists);
             if (!blank($tariffExists)) {
 
                 $tariffDto = new TariffsDto();
 
                 // $utilityProviderDto->getProiv
                 $tariffDto->setAttributes($tariffExists);
 
                 //logging
                 Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');
 
                 return Response()->json(["error" => false, "Tariff" => $tariffDto->getAttributes()], Response::HTTP_OK);
             }
             
             //Logging
             Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' failed due to Invalid Tariff Id.');
 
             return Response()->json(["error" => false, "Tariff" => ['Tariff does not exist!']], Response::HTTP_NOT_FOUND);
         } catch (\Exception $exception) {
             Log::info("Tariff Exceptional Message::" . $exception->getMessage());
             return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }
     

    /*
     * Create a Tariff.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function createTariff(Request $request)
    {
        try {
            //take all the inputs and store them.
            $inputs = $request->all();

            //generate code as per the context name
            $helper = new Helpers();
            $code = $helper->generateCode($inputs['name']);
            $inputs = array_merge($inputs, ['code' => $code]);

            //Transfer into DTO
            $tariffDto = new TariffsDto();
            $tariffDto->setAttributes($inputs);

            // Validate whether such a provider already esists using the name and code.
            $tariffExists = $this->tariffsDao->getTariffByNameOrCode($tariffDto->getTariff_name(), $tariffDto->getTariff_code());
            if (blank($tariffExists)) {
                $tariff = $this->tariffsDao->createTariff($tariffDto);
                if (!blank($tariff)) {
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to create tariff']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Tariff already exists!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Create Tariff Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /*
     * Update a Tariff.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function updateTariff(Request $request)
    {
        try {
            //take all the inputs and store them.
            $inputs = $request->all();

            Log::info("Update Tariff Request::" . json_encode($inputs));
            //Transfer into DTO
            $tariffDto = new TariffsDto();
            $tariffDto->setAttributes($inputs);

            $tariff = $this->tariffsDao->updateTariff($tariffDto);
            Log::info("Update Tariff Response Display::" . json_encode($inputs));
            if (!blank($tariff)) {
                return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Failed to create tariff']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Update Tariff Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
