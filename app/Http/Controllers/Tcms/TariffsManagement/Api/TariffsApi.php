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
    private $tariffsDao;
    private $tariffDto;
    private $helper;


    public function __construct(TariffsDaoImpl $tariffDao, TariffsDto $tariffDto, Helpers $helper)
    {
        $this->tariffsDao = $tariffDao;
        $this->tariffDto = $tariffDto;
        $this->helper = $helper;
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

            //Checking if the object has data
            if (!blank($tariffs)) {
                Log::info("Message::" . json_encode($tariffs));

                return Response()->json(["error" => false, "tariffs" => $tariffs], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "tariffs" => []], Response::HTTP_BAD_REQUEST);
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

            $requestId = $this->helper->generateRequestId();

            //Checking if the object has data
            Log::info("OriginMessage:" . $tariffExists);
            if (!blank($tariffExists)) {

                $this->tariffDto->setAttributes($tariffExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Tariff" => $this->tariffDto->getAttributes()], Response::HTTP_OK);
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

            $requestId = $this->helper->generateRequestId();

            //Checking if the object has data
            Log::info("OriginMessage:" . $tariffExists);
            if (!blank($tariffExists)) {

                // $utilityProviderDto->getProiv
                $this->tariffDto->setAttributes($tariffExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Tariff" => $this->tariffDto->getAttributes()], Response::HTTP_OK);
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

            $requestId = $this->helper->generateRequestId();

            //Checking if the object has data
            Log::info("OriginMessage:" . $tariffExists);
            if (!blank($tariffExists)) {

                // $utilityProviderDto->getProiv
                $this->tariffDto->setAttributes($tariffExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Tariff" => $this->tariffDto->getAttributes()], Response::HTTP_OK);
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
     * Get tariff by their code.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function getTariffsByUtilityProvider(Request $request)
    {
        try {
            $utilityProviderId = $request->input('utility_provider_id');
            //Checking if tariffs exists.
            $tariffsExists = $this->tariffsDao->getTariffsByUtilityProvider($utilityProviderId);

            $requestId = $this->helper->generateRequestId();

            //Checking if the object has data
            Log::info("OriginMessage:" . json_encode($tariffsExists));
            if (!blank($tariffsExists)) {

                // $utilityProviderDto->getProiv
                $this->tariffDto->setAttributes($tariffsExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Tariffs" => $this->tariffDto->getAttributes()], Response::HTTP_OK);
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

            $requestId = $this->helper->generateRequestId();

            //Checking if the object has data
            Log::info("OriginMessage:" . $tariffExists);
            if (!blank($tariffExists)) {

                // $utilityProviderDto->getProiv
                $this->tariffDto->setAttributes($tariffExists);

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Tariff" => $this->tariffDto->getAttributes()], Response::HTTP_OK);
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
            $code = $this->helper->generateCode($inputs['name']);
            $utilityProviderId = $inputs['utility_provider_id'];
            $inputs = [
                'name' => $inputs['name'], 'code' => $code, 'percentageAmount' => $inputs['percentageAmount'],
                "value" => $inputs['value']
            ];
            // $inputs = array_merge($inputs, ['code' => $code]);

            //Transfer into DTO
            $this->tariffDto->setAttributes($inputs);

            // Validate whether such a provider already esists using the name and code.
            $tariffExists = $this->tariffsDao->getTariffByName($this->tariffDto->getTariff_name());
            if (blank($tariffExists)) {
                $tariff = $this->tariffsDao->createTariff($this->tariffDto);
                if (!is_null($tariff)) {
                    $tariffId = $tariff->getTariffId();
                    $utilityProviderTariff = $this->tariffsDao->attachTariffsToUtilityProviders($utilityProviderId, $tariffId);
                    if (!is_null($utilityProviderTariff)){
                        if($utilityProviderTariff == "Tariff Exists")
                            return Response()->json(["error" => false, 'message' => ['Tariff already exists.']], Response::HTTP_OK);
                        return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                    }
                    return Response()->json(["error" => false, 'message' => ['Failed to assign tariff.']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to create tariff']], Response::HTTP_OK);
            } //else do somthing else
            else {
                //get the tariff Id
                $tariffId = $tariffExists->getTariffId();
                $utilityProviderTariff = $this->tariffsDao->attachTariffsToUtilityProviders($utilityProviderId, $tariffId);
                if (!is_null($utilityProviderTariff)){
                    if($utilityProviderTariff == "Tariff Exists")
                        return Response()->json(["error" => false, 'message' => ['Tariff already exists.']], Response::HTTP_OK);
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to attach tariff.']], Response::HTTP_OK);
            }
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
            $this->tariffDto->setAttributes($inputs);

            $tariff = $this->tariffsDao->updateTariff($this->tariffDto);
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
