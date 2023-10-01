<?php
namespace App\Http\Controllers\Tcms\Customers\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * User: Daniel.
 * Date: 22/09/2023
 */
/**
 * This Class Transfer Customers Data
 *
 *
 */

class CustomerDto
{

    use HasAttributes;

    /**
     * @param int
     * @return mixed
     */
    public function setCustomerDto($id, $full_name, $phone, $address)
    {
        $this->attributes = [];
        $this->attributes['id'] = $id;
        $this->attributes['full_name'] = $full_name;
        $this->attributes['phone'] = $phone;
        $this->attributes['address'] = $address;
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getCustomer_id()
    {
        return $this->attributes['id'];
    }

    /**
     * @param int $customer_id
     */
    public function setCustomer_id($customer_id)
    {
        $this->attributes['id'] = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getCustomer_name()
    {
        return $this->attributes['full_name'];
    }

    /**
     * @param mixed $customer_name
     */
    public function setCustomer_name($customer_name)
    {
        $this->attributes['full_name'] = $customer_name;
    }

    /**
     * @return mixed
     */
    public function getCustomer_phone()
    {
        return $this->attributes['phone'];
    }

    /**
     * @param mixed $customer_phone
     */
    public function setCustomer_phone($customer_phone)
    {
        $this->attributes['phone'] = $customer_phone;
    }

    /**
     * @return mixed
     */
    public function getCustomer_address()
    {
        return $this->attributes['address'];
    }
    /**
     * @param mixed $customer_address
     */
    public function setCustomer_address($customer_address)
    {
        $this->attributes['address'] = $customer_address;
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