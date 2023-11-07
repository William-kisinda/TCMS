<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Julius M.
 * Date: 11/09/2023
 */
/**
 * This Class Transfer Meters Information
 *
 *
 */

class ValidMeterDto
{

    use HasAttributes;

    /**
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
         $this->attributes['ackCode'] = $ackCode;
         $this->attributes['description'] = $description;
        return $this->attributes;
    }

    public function responseErrorDto($requestId, $ackCode, $description)
    {
        $this->attributes = [];
        $this->attributes['requestId'] = $requestId;
        $this->attributes['ackCode'] = $ackCode;
        $this->attributes['description'] = $description;
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
