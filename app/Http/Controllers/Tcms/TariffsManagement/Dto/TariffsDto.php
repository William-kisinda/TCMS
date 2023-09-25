<?php

namespace App\Http\Controllers\Tcms\TariffsManagement\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Daniel.
 * Date: 22/09/2023
 */
/**
 * This Class Transfer Tariffs Data
 *
 *
 */

class TariffsDto
{

    use HasAttributes;

    /**
     * @param int
     * @return mixed
     */
    public function setTariffsDto($id, $name, $code, $percentageAmount, $value)
    {
        $this->attributes = [];
        $this->attributes['id'] = $id;
        $this->attributes['name'] = $name;
        $this->attributes['code'] = $code;
        $this->attributes['percentageAmount'] = $percentageAmount;
        $this->attributes['value'] = $value;
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getTariff_id()
    {
        return $this->attributes['id'];
    }

    /**
     * @param int $tariffs_id
     */
    public function setTariff_id($tariff_id)
    {
        $this->attributes['id'] = $tariff_id;
    }

    /**
     * @return mixed
     */
    public function getTariff_name()
    {
        return $this->attributes['name'];
    }

    /**
     * @param mixed $provider_name
     */
    public function setTariff_name($tariff_name)
    {
        $this->attributes['name'] = $tariff_name;
    }

    /**
     * @return mixed
     */
    public function getTariff_code()
    {
        return $this->attributes['code'];
    }

    /**
     * @param mixed $provider_code
     */
    public function setTariff_code($tariff_code)
    {
        $this->attributes['code'] = $tariff_code;
    }

    /**
     * @return mixed
     */
    public function getTariff_percentageAmount()
    {
        return $this->attributes['percentageAmount'];
    }
    /**
     * @param mixed $provider_categories_id
     */
    public function setTariff_percentageAmount($tariff_percentage_amount)
    {
        $this->attributes['percentageAmount'] = $tariff_percentage_amount;
    }

    /**
     * @return mixed
     */
    public function getTariff_value()
    {
        return $this->attributes['value'];
    }

    /**
     * @param mixed $provider_status
     */
    public function setTariff_value($tariff_value)
    {
        $this->attributes['value'] = $tariff_value;
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
