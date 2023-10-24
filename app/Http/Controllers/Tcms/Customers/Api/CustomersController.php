<?php

namespace App\Http\Controllers\Tcms\Customers\Api;

use Exception;
use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\Customers\Dto\CustomerDto;
use App\Http\Controllers\Tcms\Customers\Dao\CustomerDaoImpl;
use App\Http\Controllers\Tcms\Utility_provider\Dao\UtilityProviderDaoImpl;

class CustomersController extends Controller
{
    private $customerDao;
    private $helpers;


    public function __construct(CustomerDaoImpl $customerDao, Helpers $helpers)
    {
        $this->customerDao = $customerDao;
        $this->helpers = $helpers;
    }

    /**
     * Display a listing of of all customers.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAllCustomers(Request $request)
    {
        //Validate roles and request information like headers and auth tokens.
        try {
            $customers = $this->customerDao->getAllCustomers();

            $requestId = $this->helpers->generateRequestId();

            //Checking if the object has data
            if (!blank($customers)) {

                Log::info("Message::" . json_encode($customers));

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "customers" => $customers], Response::HTTP_OK);
            }

            //Logging
            Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' failed.');

            return Response()->json(["error" => false, "customers" => []], Response::HTTP_BAD_REQUEST);

        } catch (\Exception $exception) {

            Log::error("Exceptional Message::" . $exception->getMessage());

            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get Customer by their id.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

     public function getCustomerById(Request $request)
     {
         try {

             $customerId = $request->input('customerId');
             //Checking if tariffs exists.
             $customerMetersExists = $this->customerDao->getCustomerById($customerId);

             $requestId = $this->helpers->generateRequestId();

             //Checking if the object has data
             Log::info("OriginMessage:" . json_encode($customerMetersExists));
             if (!blank($customerMetersExists)) {

                //logging
                Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' is successfully processed');

                return Response()->json(["error" => false, "Customer" => $customerMetersExists], Response::HTTP_OK);
             }

             //Logging
             Log::channel('daily')->info('This request with id: ' . json_encode(['request_id' => $requestId]) . ' failed due to Invalid Customer Id.');

             return Response()->json(["error" => false, "Customer" => ['Invalid Customer Id']], Response::HTTP_NOT_FOUND);
         } catch (\Exception $exception) {
             Log::error("Customer Exceptional Message::" . $exception->getMessage());
             return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }

     /*
     * Create a Customer.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
    */
    public function createCustomer(Request $request)
    {
        try {
            Log::info("Log Message:" . json_encode($request->all()));
            $utilityProviderId = $request->input('utility_provider_id');
            $utilityProviderDao = app(UtilityProviderDaoImpl::class);
            $utility_provider = $utilityProviderDao->getUtilityProviderById($utilityProviderId);
            if (is_null($utility_provider)) throw new Exception("Utility Provider doesn't exist.", 1);
            $customerDto = app(CustomerDto::class);
            $customerDto->setAttributes(['full_name' => $request->input('full_name'), 'phone' => $request->input('phone'), 'address' => $request->input('address')]);
            $customerExists = false;
            if (!$customerExists) {
                $customer = $this->customerDao->createCustomer($customerDto, $utilityProviderId);
                if (!blank($customer)) {
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to register customer']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Customer already exists!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
