<?php

namespace App\Http\Controllers\Tcms\Customers\Dao;

use App\Http\Controllers\Tcms\Customers\Dto\CustomerDto;

/**
 * This interface Access Customers Data
 * @author Daniel.
 *
 */

interface CustomerDao
{
    public function getAllCustomers();
    public function getCustomerById($customerId);
    public function getCustomerMeterNumberById($customerId);
    public function createCustomer(CustomerDto $customerDto);
}