<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderCategory extends Model
{
    use HasFactory;

    public $table = "provider_categories";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getProviderCategoryId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setProviderCategoryId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getProviderCategoryName()
    {
        return $this->attributes['name'];
    }

    /**
     * @param mixed $name
     */
    public function setProviderCategoryName($name): void
    {
        $this->attributes['name'] = $name;
    }

    /**
     * @return mixed
     */
    public function getProviderCategoryCode()
    {
        return $this->attributes['code'];
    }

    /**
     * @param mixed $code
     */
    public function setProviderCategoryCode($code): void
    {
        $this->attributes['code'] = $code;
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
