<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Api;

use App\Helpers;
use App\ErrorCode;
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
 * This Class Controls Meter validation API
 * @author Julius.
 * Email: juliusstephen1@gmail.com
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

/**
 * This is the Method in Meter validation API
 * @author Julius.
 * Email: juliusstephen1@gmail.com
 *
 */

    public function getValidMeter(Request $request)
    {
        try {
            // Retrieve the meter number from the request payload     //Minded that all the input fields are mandatory
            $meterNumber = $request->input('meterNumber');
            $amount = $request->input('amount');
            $utilityProvider = $request->input('utilityProvider');
            $userRequestId = $request->input('requestId');
            $partnerCode = $request->input('partnerCode');
            $requestTime = $request->input('requestTime');

             // Capture requestId
            $serverRequestId = $this->helpers->generateRequestId();

            //Log request information
            Log::channel('meter_validation')->info("\nThe request for Validating Meter Number with the requestId :".$serverRequestId. "\nSuccessful received with the following information :\n Request Header Information : ".json_encode($request->header()). "\nRequest body Information: ".json_encode($request->input()));


            // Checking if the meter exists in the database.
            $meterExists = $this->meterDao->checkIfMeterOfUtilityProviderExists($meterNumber, $utilityProvider);

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
                    $serverRequestId
                );

                // Now setting the provider categories array attributes.
                $this->meterDto->setAttributes($validMeterArray);


               //Log response Data
               Log::channel('meter_validation')->info("\nThe Response Data for Validating Meter Number with the requestId :".$serverRequestId. "\nSent to the user with the following Data :".json_encode($this->meterDto));

                return response()->json(["error" => false, "Meter Information" => $this->meterDto->getAttributes()], Response::HTTP_OK);


        }
            Log::channel('meter_validation')->info('\nThe Response Data for Validating Meter Number with the requestId :' . json_encode(['request_id' => $serverRequestId]) . '   ,is Failed to be  processed due to Invalid Meter Number');

            return response()->json(["error" => true, "message" => "Invalid Meter Number"]);



        } catch (\Exception $exception) {
            Log::channel('meter_validation')->error("\nRequest Failed to be processed:  Exceptional Message: " . $exception->getMessage());

            return response()->json(["error" => true, "message" => "An error occurred"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


/**
 * This is the method for validating the meter Number during Token generation process
 * @author Julius.
 * Email: juliusstephen1@gmail.com
 *
 */

    public function getMeterInfo(Request $request)
    {
        try {
             //Log received Request information
             Log::channel('meter_validation')->info("\nThe request for Validating Meter Number with the requestId :".$request->input('requestId'). "\nSuccessful received with the following information :\n Request Header Information : ".json_encode($request->header()). "\nRequest body Information: ".json_encode($request->input()));

             //Validate Inputs
             $validatedInputs = $request->validate([
                'meterNumber' => ['required','numeric','digits:12'],
                'utilityProvider' => ['required','string'],
                'requestId' => ['required','numeric'],
                'partnerCode' => ['required','alpha_num:ascii'],
                'requestTime' => ['required', 'date_format:Y-m-d H:i:s'],
             ]);

              // Retrieve the meter number from the validated request payload
            $meterNumber = $validatedInputs['meterNumber'];
            $utilityProvider = $validatedInputs['utilityProvider'];
            $requestId = $validatedInputs['requestId'];
            $partnerCode = $validatedInputs['partnerCode'];
            $requestTime = $validatedInputs['requestTime'];

            // Checking if the meter exists in the database.
            $meterExists = $this->meterDao->checkIfMeterOfUtilityProviderExists($meterNumber, $utilityProvider);

            if ($meterExists) {
                // Fetching the customer for meter validity.
                $customer = $this->customerDao->getCustomerById($meterExists->getCustomerId());
                $debtAmount = $this->debts->getDebtByMeterId($meterExists->getMeterId());
                $utilityProvider = $this->utilityProviderDao->getUtilityProviderById($meterExists->getUtilityProviderId());

                // Using the DTO to get and set object data properties.
                $validMeterArray = $this->meterDto->responseDto(
                    $meterExists->getMeterNumber(),
                    $debtAmount,
                    $meterExists->getMeterStatus(),
                    $customer['full_name'],
                    $customer['phone'],
                    $utilityProvider->getUtilityProviderName(),
                    $requestId,
                    $partnerCode,
                    $requestTime,
                    ErrorCode::INVALID_INPUT['code'],
                    ErrorCode::INVALID_INPUT['description']
                );

                // Now setting the provider categories array attributes.
                $this->meterDto->setAttributes($validMeterArray);

                //Log send Response information
             Log::channel('meter_validation')->info("\nMeter Validation Response for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($this->meterDto->getAttributes()));



                return response()->json(["error" => false, "Meter Information" => $this->meterDto->getAttributes()], Response::HTTP_OK);


        }
            $response = $this->meterDto->responseErrorDto($requestId,ErrorCode::INVALID_INPUT['code'], ErrorCode::INVALID_INPUT['description']);
                //Log Response Error
            Log::channel('meter_validation')->info("\nMeter Validation Response for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($response));

            return response()->json(["error" => true, "message" => $response], Response::HTTP_OK);



        }//Handles Validatioin Errors
        catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails, Laravel throws a ValidationException.
            // You can retrieve validation errors like this:
            $validationErrors = $e->validator->errors()->all();

            // Log the validation errors if needed
            Log::channel('meter_validation')->error("Validation Errors: " . json_encode($validationErrors));

            // Return the errors as a response
            return response()->json(["error" => true, "message" => $validationErrors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch (\Exception $exception) { // require to include error code and its description
            Log::channel('meter_validation')->error("System  failed to serach for the meter number:  Exceptional Message: " . $exception->getMessage());

            return response()->json(["error" => true, "message" => "An error occurred"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
