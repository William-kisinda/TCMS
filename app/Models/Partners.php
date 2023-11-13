<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use HasFactory;

    public $table = "partners";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getPartnerId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setPartnerId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getpartnerName()
    {
        return $this->attributes['name'];
    }

    /**
     * @param mixed $partnerName
     */
    public function setPartnerName($name): void
    {
        $this->attributes['name'] = $name;
    }


    /**
     * @return mixed
     */
    public function getPartnerCode()
    {
        return $this->attributes['code'];
    }

    /**
     * @param mixed $partnerCode
     */
    public function setPartnerCode($partnerCode): void
    {
        $this->attributes['code'] = $partnerCode;
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
