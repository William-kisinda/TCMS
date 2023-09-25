<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariffs extends Model
{
    use HasFactory;

    public $table = "tariffs";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getTariffId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setTariffId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getTariffName()
    {
        return $this->attributes['name'];
    }

    /**
     * @param mixed $name
     */
    public function setTariffName($name): void
    {
        $this->attributes['name'] = $name;
    }

    /**
     * @return mixed
     */
    public function getTariffCode()
    {
        return $this->attributes['code'];
    }

    /**
     * @param mixed $code
     */
    public function setTariffCode($code): void
    {
        $this->attributes['code'] = $code;
    }

    /**
     * @return mixed
     */
    public function getTariffAmount()
    {
        return $this->attributes['percentageAmount'];
    }

    /**
     * @param mixed $status
     */
    public function setTariffAmount($percentageAmount): void
    {
        $this->attributes['percentageAmount'] = $percentageAmount;
    }

    /**
     * @return mixed
     */
    public function getTariffValue()
    {
        return $this->attributes['value'];
    }

    /**
     * @param mixed $category
     */
    public function setUtilityProviderCategory($value): void
    {
        $this->attributes['value'] = $value;
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
