<?php
namespace App\Http\Controllers\Tcms\gui\Dto;


use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * Dashboard Data Transfer Object
 * @author Julius.
 *
 * @param null
 * @return \Illuminate\Http\JsonResponse
 */

class DashboardDto
{

    use HasAttributes;

    /**
     * @param int
     * @return mixed
     */
    public function setDashboardData($utilityProviders, $customers, $providerCategory, $customersList, $utilityProvidersList)
    {
        $this->attributes = [];
        $this->attributes['utilityProviders'] = $utilityProviders;
        $this->attributes['customers'] = $customers;
        $this->attributes['providerCategory'] = $providerCategory;
        $this->attributes['customersList'] = $customersList;
        $this->attributes['utilityProvidersList'] = $utilityProvidersList;
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
