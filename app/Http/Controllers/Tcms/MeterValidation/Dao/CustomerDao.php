<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Dao;




/**
 * This interface Access ProductCategory Data
 * @author Julius.
 *
 */

interface CustomerDao
{
    public function getAllCustomers();
    public function getCustomerById($customerId);
    //public function createMeter();
    //public function deleteMeter();
    //public function updateMeter();
    //public function getMeterByIdOrName();
}
