<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Julius.
 */
/**
 * This Class Transfer Token Management Information
 *
 *
 */

class TokenManageDto
{

    use HasAttributes;



    public function newTokenInfo($token, $meterId, $generationTime, $providerId, $requestId, $requestTime, $partnersId,$generationDate)
    {
        $this->attributes = [];
        $this->attributes['token'] = $token;
        $this->attributes['meter_id'] = $meterId;
        $this->attributes['generation_time'] = $generationTime;
        $this->attributes['utility_provider_id'] = $providerId;
        $this->attributes['request_time'] = $requestTime;
        $this->attributes['request_id'] = $requestId;
        $this->attributes['partners_id'] = $partnersId;
        $this->attributes['date'] = $generationDate;
        return $this->attributes;
    }

    public function notificationInformation($token, $meterNumber, $generationTime, $providerName, $requestId, $requestTime, $partnersCode)
    {
        $this->attributes = [];
        $this->attributes['token'] = $token;
        $this->attributes['meterNumber'] = $meterNumber;
        $this->attributes['generationTime'] = $generationTime;
        $this->attributes['providerName'] = $providerName;
        $this->attributes['requestTime'] = $requestTime;
        $this->attributes['requestId'] = $requestId;
        $this->attributes['partnersCode'] = $partnersCode;
        return $this->attributes;
    }

    public function ackResponse($meterNumber, $providerName, $requestId, $requestTime, $partnersCode, $responseTime, $message){
        $this->attributes = [];
        $this->attributes['meterNumber'] = $meterNumber;
        $this->attributes['responseTime'] = $responseTime;
        $this->attributes['providerName'] = $providerName;
        $this->attributes['requestTime'] = $requestTime;
        $this->attributes['requestId'] = $requestId;
        $this->attributes['partnersCode'] = $partnersCode;
        $this->attributes['message'] = $message;
        return $this->attributes;
    }

    public function responseErrorDto($requestId, $ackCode, $description, $errorMessage,$requestTime, $responseTime)
    {
        $this->attributes = [];
        $this->attributes['requestId'] = $requestId;
        $this->attributes['ErrorCode'] = $ackCode;
        $this->attributes['description'] = $description;
        $this->attributes['errorMessage'] = $errorMessage;
        $this->attributes['requestTime'] = $requestTime;
        $this->attributes['responseTime'] = $responseTime;
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
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
