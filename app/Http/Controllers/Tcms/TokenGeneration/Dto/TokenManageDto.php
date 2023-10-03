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
    public function setManageInfo($tokenId, $token, $meterId, $generationDate, $tariffId)
    {
        $this->attributes = [];
        $this->attributes['id'] = $tokenId;
        $this->attributes['token'] = $token;
        $this->attributes['meters_id'] = $meterId;
        $this->attributes['generation_date'] = $generationDate;
        $this->attributes['tariff_id'] = $tariffId;
        return $this->attributes;
    }

    public function setCreateInfo( $token, $meterId, $generationDate, $tariffId)
    {
        $this->attributes = [];
        $this->attributes['token'] = $token;
        $this->attributes['meters_id'] = $meterId;
        $this->attributes['generation_date'] = $generationDate;
        $this->attributes['tariff_id'] = $tariffId;
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
        return $this->attributes['meters_id'];
    }

    /**
     * @param mixed $meterId
     */
    public function setMeterId($meterId)
    {
        $this->attributes['meters_id'] = $meterId;
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
    public function getTariff_value()
    {
        return $this->attributes['tariff_id'];
    }

    /**
     * @param mixed $tariffId
     */
    public function setTariff_value($tariffId)
    {
        $this->attributes['tariff_id'] = $tariffId;
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
