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



    public function newTokenInfo($token, $meterId, $generationTime, $providerId, $requestId, $requestTime, $partnersId)
    {
        $this->attributes = [];
        $this->attributes['token'] = $token;
        $this->attributes['meter_id'] = $meterId;
        $this->attributes['generation_time'] = $generationTime;
        $this->attributes['provider_id'] = $providerId;
        $this->attributes['request_time'] = $requestTime;
        $this->attributes['request_id'] = $requestId;
        $this->attributes['partners_id'] = $partnersId;
        return $this->attributes;
    }

    public function notificationInformation($token, $meterNumber, $generationTime, $providerName, $requestId, $requestTime, $partnersCode)
    {
        $this->attributes = [];
        $this->attributes['token'] = $token;
        $this->attributes['meter_number'] = $meterNumber;
        $this->attributes['generation_time'] = $generationTime;
        $this->attributes['provider_name'] = $providerName;
        $this->attributes['request_time'] = $requestTime;
        $this->attributes['request_id'] = $requestId;
        $this->attributes['partners_code'] = $partnersCode;
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getTokenId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param int $tokenId
     */
    public function setTokenId($tokenId)
    {
        $this->attributes['id'] = $tokenId;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->attributes['token'];
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->attributes['token'] = $token;
    }

    /**
     * @return mixed
     */
    public function getMeterId()
    {
        return $this->attributes['meter_id'];
    }

    /**
     * @param mixed $meterId
     */
    public function setMeterId($meterId)
    {
        $this->attributes['meter_id'] = $meterId;
    }

    /**
     * @return mixed
     */
    public function getGenerationDate()
    {
        return $this->attributes['generation_date'];
    }
    /**
     * @param mixed $generatiotariff_id
     */
    public function setGenerationDate($generationDate)
    {
        $this->attributes['generation_date'] = $generationDate;
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
