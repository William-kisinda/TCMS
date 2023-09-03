<?php

namespace App\Http\Controllers\Tcms\ValidationRequest\Dto;

/**
 * Created by PhpStorm.
 * User: Daniel MM.
 * Date: 31/08/2023
 * Time: 3:15 PM
 */
/**
 * This Class Validates requests Data
 *
 *
 */
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class validationDto {
    use HasAttributes;

    //In this dto we put up getters and setter of the attributes of our model.
    //Meaning the columns of our Database table.

    public function getAttributesToValidate($id) {
        $this->attributes = [];
        $this->attributes['id']  = $id;
        return $attributes;
    }

    public function getUserToValidate() {
        $user = ["validated" => true, ...$this->attributes];
        return $user;
    }
}

?>