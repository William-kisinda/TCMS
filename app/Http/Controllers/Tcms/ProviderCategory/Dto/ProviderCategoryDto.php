<?php

namespace App\Http\Controllers\Tcms\ProviderCategory\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Daniel MM.
 * Date: 01/09/2023
 * Time: 3:48 PM
 */
/**
 * This Class Transfer Product Category Data
 *
 *
 */

class ProviderCategoryDto
{

    use HasAttributes;

    /**
     * @return mixed
     */
    public function getProviderCategoryDto($id, $code, $name)
    {
        $this->attributes = [];
        $this->attributes['prov_categ_id'] = $id;
        $this->attributes['prov_categ_code'] = $code;
        $this->attributes['prov_categ_name'] = $name;
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getProv_categ_id()
    {
        return $this->attributes['prov_categ_id'];
    }

    /**
     * @param mixed $prov_categ_id
     */
    public function setProv_categ_id($prov_categ_id)
    {
        $this->attributes['prov_categ_id'] = $prov_categ_id;
    }

    /**
     * @return mixed
     */
    public function getProv_categ_name()
    {
        return $this->attributes['prov_categ_name'];
    }

    /**
     * @param mixed $prov_categ_name
     */
    public function setProv_categ_name($prov_categ_name)
    {
        $this->attributes['prov_categ_name'] = $prov_categ_name;
    }

    /**
     * @return mixed
     */
    public function getProv_categ_code()
    {
        return $this->attributes['prov_categ_code'];
    }

    /**
     * @param mixed $prov_categ_code
     */
    public function setProv_categ_code($prov_categ_code)
    {
        $this->attributes['prov_categ_code'] = $prov_categ_code;
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
