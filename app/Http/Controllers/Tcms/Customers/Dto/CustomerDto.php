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
