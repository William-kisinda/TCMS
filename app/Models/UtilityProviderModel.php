<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityProviderModel extends Model
{
    use HasFactory;

    public $table = "utility_providers";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getUtilityProviderId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setUtilityProviderId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getUtilityProviderName()
    {
        return $this->attributes['provider_name'];
    }

    /**
     * @param mixed $name
     */
    public function setUtilityProviderName($name): void
    {
        $this->attributes['provider_name'] = $name;
    }

    /**
     * @return mixed
     */
    public function getUtilityProviderCode()
    {
        return $this->attributes['provider_code'];
    }

    /**
     * @param mixed $code
     */
    public function setUtilityProviderCode($code): void
    {
        $this->attributes['provider_code'] = $code;
    }

    /**
     * @return mixed
     */
    public function getUtilityProviderStatus()
    {
        return $this->attributes['provider_status'];
    }

    /**
     * @param mixed $status
     */
    public function setUtilityProviderStatus($status): void
    {
        $this->attributes['provider_status'] = $status;
    }

    /**
     * @return mixed
     */
    public function getUtilityProviderCategory()
    {
        return $this->attributes['provider_categories_id'];
    }

    /**
     * @param mixed $category
     */
    public function setUtilityProviderCategory($categoryId): void
    {
        $this->attributes['provider_categories_id'] = $categoryId;
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

    /**
     * Get the user associated with the utility provider.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    //How to check utility providers with users
    //$UPWithUsers = utility_providers::whereHas('user')->get();

    //How to check utility providers with no users
    //$usersWithoutPhone = User::doesntHave('phone')->get();

}
