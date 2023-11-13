<?php

namespace App\Http\Controllers\Tcms\Partners\Dao;

use App\Http\Controllers\Tcms\TokenGeneration\Dto\PartnersDto;

/**
 * This interface Access Partners Data
 * @author Julius.
 *
 */

interface PartnersDao
{
    public function getAllPartners();
    public function getPartnerById($partnerId);
    public function getPartnerByCode($partnerCode);
    public function createPartner(PartnersDto $partnerDto);
}
