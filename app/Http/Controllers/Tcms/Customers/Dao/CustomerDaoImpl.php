<?php

namespace App\Http\Controllers\Tcms\Customers\Dao;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Tcms\Customers\Dao\CustomerDao;
use App\Http\Controllers\Tcms\Customers\Dto\CustomerDto;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;

/**
 * This Class Controls Tariffs Datastore
 * @author Daniel.
 * Email:danielmathew460@gmail.com
 * 28/09/2023
 *
 */

class CustomerDaoImpl implements CustomerDao
{
    /**
     * @param null
     * @return array|null
     * @author Julius M
     */
    public function getAllCustomers(){
        $customers = null;
        try {
            $customersInfo = DB::table('customers')->get();
            if (!blank($customersInfo)) {

                $customersInfoArray = json_decode(json_encode($customersInfo), true);

                $customers = new Customer();
                $customers->setAttributes($customersInfoArray);

            }
        } catch (\Exception $exception) {
            Log::error("Customers Exception", $exception->getMessage());
        }
        return $customers;
    }

    /**
     * @param $customerId
     * @return Customer|null
     * @author Julius M
     */

     public function getCustomerById($customerId)
     {
         $customer = null;
         $customerMeters = null;
         $customerData = null;
         try {
             $customerInfo = DB::table('customers')->where('id', $customerId)->first();

             if (!empty($customerInfo)) {
                 // If the customer info is found, you can directly create a Customer object.
                 $customer = new Customer();
                 $customer->setAttributes((array) $customerInfo);

                 //Now we resolve customer's meter details
                 $customerMeters = $this->getCustomerMeterNumberById($customerId);

                 //Now we can redefine our return object with both customer data and their meter information.

                 $customerData = [
                    'id' => $customer->getCustomerId(),
                    'full_name' => $customer->getCustomerName(),
                    'phone' => $customer->getCustomerPhone(),
                    'address' => $customer->getCustomerAddress(),
                    'meters' => $customerMeters
                 ];
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::error("CustomerException: " . $e->getMessage());
         }

         return $customerData;
     }

    public function getCustomerMeterNumberById($customerId)
    {
        $meterDao = new MeterDaoImpl();
        $customerMeters = $meterDao->getMeterByCustomerId($customerId);
        return $customerMeters;
    }

    /**
     * @param CustomerDto $customerDto
     * @return Customer|null
     * @author Daniel MM
     */
    public function createCustomer(CustomerDto $customerDto)
    {
        $customer = null;
        $meter = null;
         try {
             $customer = new Customer();

             $customer->setAttributes($customerDto->getAttributes());
 
            //  $customer->save();

             //Get the id of newly stored customer.
            //  $customerId = $customer->id;
            $customerId = 5;

             //Create new meter for this customer having with us the id of the customer.
             $meterDao = new MeterDaoImpl();
             $meter = $meterDao->createMeter($customerId);
         } catch (\Exception $e) {
             Log::info("Customer Exception:". $e->getMessage());
         }
         return $meter;
    }
}