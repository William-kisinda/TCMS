<?php

namespace App\Http\Controllers\Tcms\Customers\Dao;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\Customers\Dao\CustomerDao;
use App\Http\Controllers\Tcms\Customers\Dto\CustomerDto;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDao;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;
use App\Models\Meter;

/**
 * This Class Controls Tariffs Datastore
 * @author Daniel.
 * Email:danielmathew460@gmail.com
 * 28/09/2023
 *
 */

class CustomerDaoImpl implements CustomerDao
{

    protected $customers;
    private $meterDao;

    public function __construct(Customer $customers, MeterDaoImpl $meterDaoImpl)
    {
        $this->customers = $customers;
        $this->meterDao = $meterDaoImpl;
    }

    /**
     * @param null
     * @return array|null
     * @author Julius M
     */
    public function getAllCustomers()
    {
        try {
            $customersInfo = DB::table('customers')->get();
            if (!blank($customersInfo)) {

                $customersInfoArray = json_decode(json_encode($customersInfo), true);

                $this->customers->setAttributes($customersInfoArray);
            }
        } catch (\Exception $exception) {
            Log::error("Customers Exception", $exception->getMessage());
        }
        return $this->customers;
    }

    /**
     * @param $customerId
     * @return Customer|null
     * @author Julius M
     */

    public function getCustomerById($customerId)
    {
        $customerData = null;
        try {
            $customerInfo = DB::table('customers')->where('id', $customerId)->first();

            if (!empty($customerInfo)) {
                // If the customer info is found, you can directly create a Customer object.

                $this->customers->setAttributes((array) $customerInfo);

                //Now we resolve customer's meter details
                $customerMeters = $this->getCustomerMeterNumberById($customerId);

                //Now we can redefine our return object with both customer data and their meter information.

                $customerData = [
                    'id' => $this->customers->getCustomerId(),
                    'full_name' => $this->customers->getCustomerName(),
                    'phone' => $this->customers->getCustomerPhone(),
                    'address' => $this->customers->getCustomerAddress(),
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
        $meter = app(Meter::class);
        $meterDao = new MeterDaoImpl($meter);
        $customerMeters = $meterDao->getMeterByCustomerId($customerId);
        return $customerMeters;
    }

    /**
     * @param $customerName, $customerPhone
     * @return Customer|null
     * @author Daniel MM
     */
    public function checkIfCustomerExists($customerName, $customerPhone)
    {
        $customerExists = null;
        try {
            $customerInfo = DB::table('customers')->where('full_name', $customerName)->orWhere('phone', $customerPhone)->first();

            if (!empty($customerInfo)) {
                // If the customer info is found, you can directly create a Customer object..
                $customerExists = $customerInfo;
                $this->customers->setAttributes((array) $customerInfo);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Customer exists Exception: " . $e->getMessage());
        }
        return $customerExists;
    }

    /**
     * @param CustomerDto $customerDto
     * @return Customer|null
     * @author Daniel MM
     */
    public function createCustomer(CustomerDto $customerDto, $utility_provider_id)
    {
        $meter = null;
        try {
            $this->customers->setAttributes($customerDto->getAttributes());

            $customerExists = $this->checkIfCustomerExists($this->customers->getCustomerName(), $this->customers->getCustomerPhone());

            if (is_null($customerExists)) {

                $this->customers->save();

                //Get the id of newly stored customer.
                $customerId = $this->customers->getCustomerId();
            } else {
                //Get the id of newly stored customer.
                $customerId = $this->customers->getCustomerId();
            }

            //Create new meter for this customer having with us the id of the customer.
            // $meter = app(Meter::class);
            // $meterDao = new MeterDaoImpl($meter);

            $meter = $this->meterDao->createMeter($customerId, $utility_provider_id);
            Log::channel('daily')->info('Meter with customer id: ' . json_encode($customerId));
        } catch (\Exception $e) {
            Log::error("Customer Create Exception:" . $e->getMessage());
        }
        return $meter;
    }
}
