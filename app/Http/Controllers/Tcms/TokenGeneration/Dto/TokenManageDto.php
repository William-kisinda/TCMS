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

    /**
     * @param int
     * @return mixed
     */
    public function setManageInfo($tokenId, $token, $meterId, $generationDate, $utility_provider_id,$requestId)
    {
        $this->attributes = [];
        $this->attributes['id'] = $tokenId;
        $this->attributes['token'] = $token;
        $this->attributes['meter_id'] = $meterId;
        $this->attributes['generation_date'] = $generationDate;
        $this->attributes['utility_provider_id'] = $utility_provider_id;
        $this->attributes['requestId'] = $requestId;
        return $this->attributes;
    }

    public function setCreateInfo( $token, $meterId, $generationDate, $utility_provider_id, $requestId)
    {
        $this->attributes = [];
        $this->attributes['token'] = $token;
        $this->attributes['meter_id'] = $meterId;
        $this->attributes['generation_date'] = $generationDate;
        $this->attributes['utility_provider_id'] = $utility_provider_id;
        $this->attributes['requestId'] = $requestId;
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
     * @return mixed
     */
    public function getUtilityProviderId()
    {
        return $this->attributes['utility_provider_id'];
    }
    /**
     * @param mixed $generatiotariff_id
     */
    public function setUtilityProviderId($utility_provider_id)
    {
        $this->attributes['utility_provider_id'] = $utility_provider_id;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->attributes['requestId'];
    }
    /**
     * @param mixed $generatiotariff_id
     */
    public function setRequestId($requestId)
    {
        $this->attributes['requestId'] = $requestId;
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
