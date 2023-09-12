<?php
namespace App\Http\Controllers\Tcms\MeterValidation\Dao;

use App\Models\Meter;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\MeterValidation\Dao\CustomerDao;

/**
 * This Class Controls Product Category Datastore
 * @author Julius.
 * Email:juliusstephen1@gmail.com
 * 11/09/2023
 *
 */

class CustomerDaoImpl implements CustomerDao
{

    /**
     * @param $meterId
     * @return Customer|null
     * @author Julius M
     */

     public function getCustomerById($customerId)
     {
         $customer = null;

         try {
             $customerInfo = DB::table('customers')->where('id', $customerId)->first();

             if (!empty($customerInfo)) {
                 // If the meter info is found, you can directly create a Meter object.
                 $customer = new Customer();
                 $customer->setAttributes((array) $customerInfo);
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::error("CustomerException: " . $e->getMessage());
         }

         return $customer;
     }


     /**
     * @param null
     * @return Meter|null
     * @author Julius M
     */
    public function getAllCustomers(){
        $customers = null;
        try {
            $customersInfo = DB::table('customers')->get();
            if (!blank($customersInfo)) {

                $customersInfoArray = json_decode(json_encode($customersInfo), true);

                // foreach ($providerCategoriesInfoArray as $prodCategInfo) {
                # code...
                $customers = new Customer();
                $customers->setAttributes($customersInfoArray);

                // array_push($providerCategoryArray, $providerCategory);
                // }
            }
        } catch (\Exception $exception) {
            Log::error("MetersException", $exception->getMessage());
        }
        return $customers;
    }

}
