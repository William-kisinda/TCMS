<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    public $table = "meters";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getMeterId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setMeterId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getMeterNumber()
    {
        return $this->attributes['meter_number'];
    }

    /**
     * @param mixed $meterNumber
     */
    public function setMeterNumber($meterNumber): void
    {
        $this->attributes['meter_number'] = $meterNumber;
    }

    /**
     * @return mixed
     */
    public function getDebtAmount()
    {
        return $this->attributes['debt'];
    }

    /**
     * @param mixed $debtAmount
     */
    public function setDebtAmount($debtAmount): void
    {
        $this->attributes['debt'] = $debtAmount;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->attributes['customers_id'];
    }

    /**
     * @param mixed $debtAmount
     */
    public function setCustomerId($customerId): void
    {
        $this->attributes['customers_id'] = $customerId;
    }

    /**
     * @return mixed
     */
    public function getMeterStatus()
    {
        return $this->attributes['status'];
    }

    /**
     * @param mixed $meterStatus
     */
    public function setMeterStatus($meterStatus): void
    {
        $this->attributes['status'] = $meterStatus;
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
