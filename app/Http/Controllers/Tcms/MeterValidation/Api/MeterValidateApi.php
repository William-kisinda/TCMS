<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Api;


use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\MeterValidation\Dao\MeterDaoImp;
use App\Http\Controllers\Tcms\MeterValidation\Dto\ValidMeterDto;
use App\Http\Controllers\Tcms\MeterValidation\Dao\CustomerDaoImpl;
//use App\Http\Controllers\Tcms\MeterValidation\Api\MeterValidateApi;
use App\Http\Controllers\Tcms\Utility_provider\Dao\UtilityProviderDao;

class MeterValidateApi extends Controller
{
    private $meterDao;
    private $customerDao;

    public function __construct(MeterDaoImp $meterDao, CustomerDaoImpl $customerDao)
    {
        $this->meterDao = $meterDao;
        $this->customerDao = $customerDao;
    }

    public function getValidMeter(Request $request)
    {
        try {

            // Retrieve the meter number from the request payload
            $meter_num = $request->input('meter_num');

            // Checking if the meter exists in the database.
            $meterExists = $this->meterDao->getMeterById($meter_num);

            if (!empty($meterExists)) {
                // Fetching the customer for meter validity.
                $customer = $this->customerDao->getCustomerById($meterExists->getCustomerId());

                // Using the DTO to get and set object data properties.
                $validMeterDto = new ValidMeterDto();
                $validMeterArray = $validMeterDto->validMeter(
                    $meterExists->getMeterId(),
                    $meterExists->getMeterNumber(),
                    $meterExists->getDebtAmount(),
                    $meterExists->getMeterStatus(),
                    $customer->getCustomerName()
                );

                // Now setting the provider categories array attributes.
                $validMeterDto->setAttributes($validMeterArray);

                return response()->json(["error" => false, "Meter Information" => $validMeterDto->getAttributes()], Response::HTTP_OK);
        }

            return response()->json(["error" => true, "message" => "Invalid Meter Number"], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            Log::error("Exceptional Message: " . $exception->getMessage());

            return response()->json(["error" => true, "message" => "An error occurred"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
