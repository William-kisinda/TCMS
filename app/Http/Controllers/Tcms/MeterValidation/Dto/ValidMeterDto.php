<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Julius M.
 * Date: 11/09/2023
 */
/**
 * This Class Transfer Meters Information(Data Transfer Object)
 *
 *
 */

class ValidMeterDto
{

    use HasAttributes;

    /**method used to create attribute list for saving data in the database
     * @return mixed
     */
    public function validMeter($id, $meterNumber, $debtAmount, $status, $customerName, $customerPhone, $utility_provider, $utilityProviderId, $amount, $requestId)
    {
        $this->attributes = [];
        $this->attributes['id'] = $id;
        $this->attributes['meterNumber'] = $meterNumber;
        $this->attributes['debt'] = $debtAmount;
        $this->attributes['status'] = $status;
        $this->attributes['customerName'] = $customerName;
        $this->attributes['customerPhone'] = $customerPhone;
        $this->attributes['utilityProvider'] = $utility_provider;
        $this->attributes['utilityProvider_id'] = $utilityProviderId;
        $this->attributes['amount'] = $amount;
        $this->attributes['requestId'] = $requestId;
        return $this->attributes;
    }

    /**method used to create attribute list for returning success response to the client
     * @return mixed
     */
    public function responseDto($meterNumber, $debtAmount, $status, $customerName, $customerPhone, $utilityProvider, $requestId,$partnerCode,$requestTime,$ackCode,$description) //Error Management(error code , and description) is still not implemented
    {
        $this->attributes = [];
        $this->attributes['meternumber'] = $meterNumber;
        $this->attributes['debt'] = $debtAmount;
        $this->attributes['status'] = $status;
        $this->attributes['customerName'] = $customerName;
        $this->attributes['customerPhone'] = $customerPhone;
        $this->attributes['utilityProvider'] = $utilityProvider;
        $this->attributes['requestId'] = $requestId;
        $this->attributes['partnerCode'] = $partnerCode;
        $this->attributes['requestTime'] = $requestTime;
        $this->attributes['requestId'] = $requestId;
         $this->attributes['ErrorCode'] = $ackCode;
         $this->attributes['description'] = $description;
        return $this->attributes;
    }

    /**method used to create attribute list for returning response Error to the client
     * @return mixed
     */
    public function responseErrorDto($requestId, $ackCode, $description, $errorMessage)
    {
        $this->attributes = [];
        $this->attributes['requestId'] = $requestId;
        $this->attributes['ErrorCode'] = $ackCode;
        $this->attributes['description'] = $description;
        $this->attributes['errorMessage'] = $errorMessage;
        return $this->attributes;
    }
    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

}
