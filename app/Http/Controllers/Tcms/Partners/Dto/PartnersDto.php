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

class PartnersDto
{

    use HasAttributes;


    public function newPartner($name, $code)
    {
        $this->attributes = [];
        $this->attributes['name'] = $name;
        $this->attributes['code'] = $code;
        return $this->attributes;
    }

    public function responSuccessDto($name, $code, $errorCode, $description)
    {
        $this->attributes = [];
        $this->attributes['name'] = $name;
        $this->attributes['code'] = $code;
        $this->attributes['errorCode'] = $errorCode;
        $this->attributes['description'] = $description;
        return $this->attributes;
    }

    public function responseErrorDto($name, $code)
    {
        $this->attributes = [];
        $this->attributes['name'] = $name;
        $this->attributes['code'] = $code;
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
