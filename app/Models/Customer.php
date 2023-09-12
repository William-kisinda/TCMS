<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $table = "customers";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setCustomerId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->attributes['full_name'];
    }

    /**
     * @param mixed $customerName
     */
    public function setCustomerName($customerName): void
    {
        $this->attributes['full_name'] = $customerName;
    }

    /**
     * @return mixed
     */
    public function getCustomerPhone()
    {
        return $this->attributes['phone'];
    }

    /**
     * @param mixed $customerPhone
     */
    public function setCsutomerPhone($customerPhone): void
    {
        $this->attributes['phone'] = $customerPhone;
    }

     /**
     * @return mixed
     */
    public function getCustomerAddress()
    {
        return $this->attributes['address'];
    }

    /**
     * @param mixed $customerPhone
     */
    public function setCsutomerAddress($customerAddress): void
    {
        $this->attributes['address'] = $customerAddress;
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
