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
