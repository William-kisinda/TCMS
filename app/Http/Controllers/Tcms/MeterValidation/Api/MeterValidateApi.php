<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Api;

use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\Debts\Dao\DebtDaoImpl;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;
use App\Http\Controllers\Tcms\Customers\Dao\CustomerDaoImpl;
use App\Http\Controllers\Tcms\MeterValidation\Dto\ValidMeterDto;
use App\Http\Controllers\Tcms\Utility_provider\Dao\UtilityProviderDaoImpl;

/**
 * This Class Controls Product Category Datastore
 * @author Julius.
 * Email:juliusstephen1@gmail.com
 *
 */

class MeterValidateApi extends Controller
{
    private $meterDao;
    private $customerDao;
    private $debts;
    private $utilityProviderDao;
    private $helpers;
    private $meterDto;

    public function __construct(MeterDaoImpl $meterDao, CustomerDaoImpl $customerDao, DebtDaoImpl $debts, UtilityProviderDaoImpl $utilityProviderDao, Helpers $helpers, ValidMeterDto $meterDto)
    {
        $this->meterDao = $meterDao;
        $this->customerDao = $customerDao;
        $this->debts = $debts;
        $this->utilityProviderDao = $utilityProviderDao;
        $this->helpers = $helpers;
        $this->meterDto = $meterDto;
    }

    public function getValidMeter(Request $request)
    {
        try {
            // Retrieve the meter number from the request payload
            $meter_num = $request->input('meter_num');
            $amount = $request->input('amount');
            $utilityProvider = $request->input('utilityProvider');

             // Capture requestId
            $requestId = $this->helpers->generateRequestId();


            // Checking if the meter exists in the database.
            $meterExists = $this->meterDao->checkIfMeterOfUtilityProviderExists($meter_num, $utilityProvider);

            if (!empty($meterExists)) {
                // Fetching the customer for meter validity.
                $customer = $this->customerDao->getCustomerById($meterExists->getCustomerId());
                $debtAmount = $this->debts->getDebtByMeterId($meterExists->getMeterId());
                $utilityProvider = $this->utilityProviderDao->getUtilityProviderById($meterExists->getUtilityProviderId());

                // Using the DTO to get and set object data properties.
                $validMeterArray = $this->meterDto->validMeter(
                    $meterExists->getMeterId(),
                    $meterExists->getMeterNumber(),
                    $debtAmount,
                    $meterExists->getMeterStatus(),
                    $customer['full_name'],
                    $customer['phone'],
                    $utilityProvider->getUtilityProviderName(),
                    $utilityProvider->getUtilityProviderId(),
                    $amount,
                    $requestId
                );

                // Now setting the provider categories array attributes.
                $this->meterDto->setAttributes($validMeterArray);

                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');


                return response()->json(["error" => false, "Meter Information" => $this->meterDto->getAttributes()], Response::HTTP_OK);


        }
            Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is Failed to be  processed due to Invalid Meter Number');

            return response()->json(["error" => true, "message" => "Invalid Meter Number"]);



        } catch (\Exception $exception) {
            Log::error("Exceptional Message: " . $exception->getMessage());

            return response()->json(["error" => true, "message" => "An error occurred"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMeterInfo(Request $request)
    {
        try {
            // Retrieve the meter number from the request payload
            $meter_num = $request->input('meter_num');
            $utilityProvider = $request->input('utilityProvider');

             // Capture requestId
            $requestId = $this->helpers->generateRequestId();


            // Checking if the meter exists in the database.
            $meterExists = $this->meterDao->checkIfMeterOfUtilityProviderExists($meter_num, $utilityProvider);

            if (!empty($meterExists)) {
                // Fetching the customer for meter validity.
                $customer = $this->customerDao->getCustomerById($meterExists->getCustomerId());
                $debtAmount = $this->debts->getDebtByMeterId($meterExists->getMeterId());
                $utilityProvider = $this->utilityProviderDao->getUtilityProviderById($meterExists->getUtilityProviderId());

                // Using the DTO to get and set object data properties.
                $validMeterArray = $this->meterDto->meterInfo(
                    $meterExists->getMeterId(),
                    $meterExists->getMeterNumber(),
                    $debtAmount,
                    $meterExists->getMeterStatus(),
                    $customer['full_name'],
                    $customer['phone'],
                    $utilityProvider->getUtilityProviderName(),
                    $utilityProvider->getUtilityProviderId(),
                    $requestId
                );

                // Now setting the provider categories array attributes.
                $this->meterDto->setAttributes($validMeterArray);

                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');


                return response()->json(["error" => false, "Meter Information" => $this->meterDto->getAttributes()], Response::HTTP_OK);


        }
            Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is Failed to be  processed due to Invalid Meter Number');

            return response()->json(["error" => true, "message" => "Invalid Meter Number"]);



        } catch (\Exception $exception) {
            Log::error("Exceptional Message: " . $exception->getMessage());

            return response()->json(["error" => true, "message" => "An error occurred"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
