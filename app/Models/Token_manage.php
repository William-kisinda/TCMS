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
    public function getGenerationDate()
    {
        return $this->attributes['generation_date'];
    }

    /**
     * @param mixed $generationDate
     */
    public function setGenerationDate($generation_date): void
    {
        $this->attributes['generation_date'] = $generation_date;
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
        return $this->attributes['requestId'];
    }

    /**
     * @param mixed $requestId
     */
    public function setRequestId($requestId): void
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
