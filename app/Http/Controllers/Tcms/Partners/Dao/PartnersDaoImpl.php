<?php

namespace App\Http\Controllers\Tcms\Partners\Dao;


use App\Models\Partners;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\PartnersDto;

/**
 * This Class is for Partners Information data access
 * @author Julius.
 *
 */

class PartnersDaoImpl implements PartnersDao
{
    protected $partner;

    public function __construct(Partners $partner) {
        $this->partner = $partner;
    }

    /**
     * Return All Partners
     * @param null
     * @return array|null
     * @author Julius
     */
    public function getAllPartners()
    {
        try {
            $partnersData = DB::table('partners')->get();
            if ($partnersData) {
                return $partnersData;
            }
            return null;
        } catch (\Exception $exception) {
            Log::error("Partner Information Exception:" . $exception->getMessage());
            return null;
        }
    }

    /**
     * Return the searched Partner
     * @param $partnerId
     * @return Partners|null
     * @author Julius
     */

    public function getPartnerById($partnerId)
    {

        try {
            $partnerData = DB::table('partners')->where('id', $partnerId)->first();

            if ($partnerData) {
                $this->partner->setAttributes($partnerData);
                return $this->partner;
            }
            return null;
        } catch (\Exception $e) {
            Log::error("Partners Information Exception: " . $e->getMessage());
            return null;
        }
    }


    /**
     * @param $partnerCode
     * @return Partners|null
     * @author Julius
     */

    public function getPartnerByCode($partnerCode)
    {
        try {
            $partnerData = DB::table('partners')->where('code', $partnerCode)->first();

            if ($partnerData) {
                $this->partner->setAttributes(json_decode(json_encode($partnerData), true));
                return $this->partner;
            }
            return null;
        } catch (\Exception $e) {
            Log::error("Partner Get Info Exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @param $partnerDto
     * @return Partner|null
     * @author Julius
     */

     public function createPartner($partner)
     {
         try {
            $this->partner->setAttributes($partner);
            $this->partner->save();
            return $this->partner;
         } catch (\Exception $e) {
           Log::error( "Partner create Exception:". $e->getMessage());
           return null;
         }
     }
}
