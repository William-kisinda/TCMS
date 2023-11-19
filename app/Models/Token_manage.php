<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token_manage extends Model
{
    use HasFactory;

    public $table = "token_manage";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getTokenId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setTokenId($id): void
    {
        $this->attributes['id'] = $id;
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
    public function setMeterId($meterId): void
    {
        $this->attributes['meter_id'] = $meterId;
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
    public function setToken($token): void
    {
        $this->attributes['token'] = $token;
    }

    /**
     * @return mixed
     */
    public function getGenerationTime()
    {
        return $this->attributes['generation_time'];
    }

    /**
     * @param mixed $generationTime
     */
    public function setGenerationTime($generation_time): void
    {
        $this->attributes['generation_time'] = $generation_time;
    }

     /**
     * @return mixed
     */
    public function getGenerationDate()
    {
        return $this->attributes['date'];
    }

    /**
     * @param mixed $generationDate
     */
    public function setGenerationDate($generationDate): void
    {
        $this->attributes['date'] = $generationDate;
    }

    /**
     * @return mixed
     */
    public function getRequestTime()
    {
        return $this->attributes['request_time'];
    }

    /**
     * @param mixed request_time
     */
    public function setRequestTime($request_time): void
    {
        $this->attributes['request_time'] = $request_time;
    }

    /**
     * @return mixed
     */
    public function getUtilityProviderId()
    {
        return $this->attributes['utility_provider_id'];
    }

    /**
     * @param mixed $utilityProviderId
     */
    public function setUtilityProviderId($utilityProviderId): void
    {
        $this->attributes['utility_provider_id'] = $utilityProviderId;
    }


     /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->attributes['request_id'];
    }

    /**
     * @param mixed $requestId
     */
    public function setRequestId($requestId): void
    {
        $this->attributes['request_id'] = $requestId;
    }


     /**
     * @return mixed
     */
    public function getPartnersId()
    {
        return $this->attributes['partners_id'];
    }

    /**
     * @param mixed $partnersId
     */
    public function setPartnersId($partnersId): void
    {
        $this->attributes['partners_id'] = $partnersId;
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
