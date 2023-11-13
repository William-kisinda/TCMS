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
use Illuminate\Support\Facades\Date;

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
    private $meterDto;

    public function __construct(MeterDaoImpl $meterDao, CustomerDaoImpl $customerDao, DebtDaoImpl $debts, UtilityProviderDaoImpl $utilityProviderDao, ValidMeterDto $meterDto)
    {
        $this->meterDao = $meterDao;
        $this->customerDao = $customerDao;
        $this->debts = $debts;
        $this->utilityProviderDao = $utilityProviderDao;
        $this->meterDto = $meterDto;
    }


/**
 * This is the method for validating meter Number
 * @author Julius.
 * Email: juliusstephen1@gmail.com
 *
 */

    public function getValidMeter(Request $request)
    {
        try {
             //Log received Request information
             Log::channel('meter_validation')->info("\nThe request for Validating Meter Number with the requestId :".$request->input('requestId'). "\nSuccessful received with the following information :\n Request Header Information : ".json_encode($request->header()). "\nRequest body Information: ".json_encode($request->input()));

             //Validate received Inputs
             $validatedInputs = $request->validate([
                'meterNumber' => ['required','numeric','digits:12'],
                'utilityProvider' => ['required','numeric'],
                'requestId' => ['required','numeric'],
                'partnerCode' => ['required','alpha_num:ascii'],
                'requestTime' => ['required', 'date_format:Y-m-d H:i:s', 'before_or_equal:' . Date::now()],
             ]);

              // Retrieve the meter information from the validated request payload
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

                // Setup Data to the DTO object to be transfered
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
                    ErrorCode::REQUEST_SUCESS['code'],
                    ErrorCode::REQUEST_SUCESS['description']
                );
                $this->meterDto->setAttributes($validMeterArray);

                //Log send Response information
             Log::channel('meter_validation')->info("\nMeter Validation Response for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($this->meterDto->getAttributes()));



            return response()->json(['data'=>$this->meterDto->getAttributes()], Response::HTTP_OK);


        }else{
            $response = $this->meterDto->responseErrorDto($requestId,ErrorCode::METERNUMBER_ERROR['code'], ErrorCode::METERNUMBER_ERROR['description'],"Meter does Not exist", $requestTime, Date::now());
                //Log Response Error
            Log::channel('meter_validation')->info("\nMeter Validation Response for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($response));

            return response()->json(['data'=>$this->meterDto->getAttributes()], Response::HTTP_NOT_FOUND);
        }
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $requestId = $request->input('requestId');
            // If validation fails, Laravel throws a ValidationException. Errors can be retrieved as follows
            $validationErrors = $e->validator->errors()->all();
            $response = $this->meterDto->responseErrorDto($requestId,ErrorCode::INVALID_INPUT['code'], ErrorCode::INVALID_INPUT['description'], $validationErrors,$requestTime,Date::now());
                //Log Response Error
            Log::channel('meter_validation')->error("\nMeter Validation Response for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($response));
            return response()->json(['data'=>$this->meterDto->getAttributes()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch (\Exception $exception) {
            $requestId = $request->input('requestId');
            $response = $this->meterDto->responseErrorDto($requestId,ErrorCode::SERVER_ERROR['code'], ErrorCode::SERVER_ERROR['description'],$exception->getMessage(),$requestTime,Date::now());
            //Log Response Error
            Log::channel('meter_validation')->error("\nMeter Validation Response for the request with the requestId :".$requestId. "\nSuccessful send the user following information : ".json_encode($response));
            return response()->json(['data'=>$this->meterDto->getAttributes()] , Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
