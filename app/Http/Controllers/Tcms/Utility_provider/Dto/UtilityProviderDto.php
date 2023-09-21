<?php

namespace App\Http\Controllers\Tcms\Utility_provider\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Julius.
 * Date: 17/09/2023
 */
/**
 * This Class Transfer Utility Provider Data
 *
 *
 */

class UtilityProviderDto
{

    use HasAttributes;

    /**
     * @return mixed
     */
    public function setProviderDto($id, $provider_code, $provider_name, $provider_status, $provider_categories_id)
    {
        $this->attributes = [];
        $this->attributes['id'] = $id;
        $this->attributes['provider_code'] = $provider_code;
        $this->attributes['provider_name'] = $provider_name;
        $this->attributes['provider_status'] = $provider_status;
        $this->attributes['provider_categories_id'] = $provider_categories_id;
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getProvider_id()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $prov_id
     */
    public function setProvider_id($provider_id)
    {
        $this->attributes['id'] = $provider_id;
    }

    /**
     * @return mixed
     */
    public function getProvider_name()
    {
        return $this->attributes['provider_name'];
    }

    /**
     * @param mixed $provider_name
     */
    public function setProvider_name($provider_name)
    {
        $this->attributes['provider_name'] = $provider_name;
    }

    /**
     * @return mixed
     */
    public function getProvider_code()
    {
        return $this->attributes['provider_code'];
    }

    /**
     * @param mixed $provider_code
     */
    public function setProvider_code($provider_code)
    {
        $this->attributes['provider_code'] = $provider_code;
    }


    // public function setProvider_categories_code($provider_categories_code)
    // {
    //     $this->attributes['provider_categories_code'] = $provider_categories_code;
    // }


    // public function getProvider_categories_code()
    // {
    //     return $this->attributes['provider_categories_code'];
    // }

    /**
     * @param mixed $provider_categories_id
     */
    public function setProvider_categories_id($provider_categories_id)
    {
        $this->attributes['provider_categories_id'] = $provider_categories_id;
    }

    /**
     * @return mixed
     */
    public function getProvider_categories_id()
    {
        return $this->attributes['provider_categories_id'];
    }

    /**
     * @return mixed
     */
    public function getProvider_status()
    {
        return $this->attributes['provider_status'];
    }

    /**
     * @param mixed $provider_status
     */
    public function setProvider_status($provider_status)
    {
        $this->attributes['provider_status'] = $provider_status;
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
