<?php

namespace App\Http\Controllers\Tcms\MeterValidation\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Julius M.
 * Date: 11/09/2023
 */
/**
 * This Class Transfer Meters Information
 *
 *
 */

class ValidMeterDto
{

    use HasAttributes;

    /**
     * @return mixed
     */
    public function validMeter($id, $meterNumber, $debtAmount, $status,$customerName)
    {
        $this->attributes = [];
        $this->attributes['id'] = $id;
        $this->attributes['meterNumber'] = $meterNumber;
        $this->attributes['debt'] = $debtAmount;
        $this->attributes['status'] = $status;
        $this->attributes['customerName'] = $customerName;
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
