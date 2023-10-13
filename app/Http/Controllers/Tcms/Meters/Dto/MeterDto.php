<?php

namespace App\Http\Controllers\Tcms\Meters\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Daniel.
 * Date: 22/09/2023
 */
/**
 * This Class Transfer Meters Data
 *
 *
 */

class MeterDto
{

    use HasAttributes;

    /**
     * @param int
     * @return mixed
     */
    public function setMeterDto($id, $meter_number, $customers_id, $status, $utility_provider_id)
    {
        $this->attributes = [];
        $this->attributes['id'] = $id;
        $this->attributes['meternumber'] = $meter_number;
        $this->attributes['customers_id'] = $customers_id;
        $this->attributes['status'] = $status;
        $this->attributes['utility_provider_id'] = $utility_provider_id;
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getMeter_id()
    {
        return $this->attributes['id'];
    }

    /**
     * @param int $customer_id
     */
    public function setMeter_id($meter_id)
    {
        $this->attributes['id'] = $meter_id;
    }

    /**
     * @return mixed
     */
    public function getMeter_number()
    {
        return $this->attributes['meternumber'];
    }

    /**
     * @param mixed $customer_name
     */
    public function setMeter_number($meter_number)
    {
        $this->attributes['meternumber'] = $meter_number;
    }

    /**
     * @return mixed
     */
    public function getMeter_customer_id()
    {
        return $this->attributes['customers_id'];
    }

    /**
     * @param mixed $customer_phone
     */
    public function setMeter_customer_id($customer_id)
    {
        $this->attributes['customers_id'] = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getMeter_status()
    {
        return $this->attributes['status'];
    }
    /**
     * @param mixed $customer_address
     */
    public function setMeter_status($meter_status)
    {
        $this->attributes['status'] = $meter_status;
    }

    /**
     * @return mixed
     */
    public function getMeter_utility_provider_id()
    {
        return $this->attributes['utility_provider_id'];
    }

    /**
     * @param mixed $customer_phone
     */
    public function setMeter_utility_provider_id($utility_provider_id)
    {
        $this->attributes['utility_provider_id'] = $utility_provider_id;
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