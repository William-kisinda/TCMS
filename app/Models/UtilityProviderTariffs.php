<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityProviderTariffs extends Model
{
    use HasFactory;

    public $table = "utility_providers_tariffs";
    public $timestamps = false;
    public $primaryKey = 'id';

    /**
     * @return mixed
     */
    public function getUtilityProvidersTariffsId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setUtilityProvidersTariffsId($id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getTariffId()
    {
        return $this->attributes['tariff_id'];
    }

    /**
     * @param mixed $tariff_id
     */
    public function setTariffId($tariff_id): void
    {
        $this->attributes['tariff_id'] = $tariff_id;
    }

    /**
     * @return mixed
     */
    public function getUtilityProvidersId()
    {
        return $this->attributes['utility_provider_id'];
    }

    /**
     * @param mixed $utility_provider_id
     */
    public function setUtilityProvidersId($utility_provider_id): void
    {
        $this->attributes['utility_provider_id'] = $utility_provider_id;
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