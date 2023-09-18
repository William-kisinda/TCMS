<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    public $table = "utility_providers";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setProviderId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getProviderName()
    {
        return $this->attributes['provider_name'];
    }

    /**
     * @param mixed $providerName
     */
    public function setProviderName($providerName): void
    {
        $this->attributes['provider_name'] = $providerName;
    }

    /**
     * @return mixed
     */
    public function getProviderCode()
    {
        return $this->attributes['provider_code'];
    }

    /**
     * @param mixed $providerCode
     */
    public function setProviderCode($providerCode): void
    {
        $this->attributes['provider_code'] = $providerCode;
    }

     /**
     * @return mixed
     */
    public function getProviderStatus()
    {
        return $this->attributes['provider_status'];
    }

    /**
     * @param mixed $providerStatus
     */
    public function setProviderStatus($providerStatus): void
    {
        $this->attributes['provider_status'] = $providerStatus;
    }

     /**
     * @return mixed
     */
    public function getProviderCategoriesCode()
    {
        return $this->attributes['provider_categories_code'];
    }

    /**
     * @param mixed $providerCategoriesCode
     */
    public function setCProviderCategoriesCode($providerCategoriesCode): void
    {
        $this->attributes['provider_categories_code'] = $providerCategoriesCode;
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
