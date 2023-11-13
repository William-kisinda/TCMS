<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Dao;

use App\Models\Tariffs;
use App\Models\Token_manage;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDao;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;
use App\Job\TokenManage;

/**
 * This Class is for Token Information data access
 * @author Julius.
 *
 */

class TokenManageDaoImp implements TokenManageDao
{
    protected $tokenManage;

    public function __construct(Token_manage $tokenManage) {
        $this->tokenManage = $tokenManage;
    }
    
    /**
     * @param null
     * @return array|null
     * @author Julius
     */
    public function getAllInfo()
    {
        try {
            $tokenData = DB::table('token_manage')->get();
            if ($tokenData) {
                return $tokenData;
            }
            return null;
        } catch (\Exception $exception) {
            Log::error("Token Information Exception:" . $exception->getMessage());
            return null;
        }
    }

    /**
     * @param $tokenId
     * @return Token_manage|null
     * @author Julius
     */

    public function getInfoById($tokenId)
    {

        try {
            $tokenData = DB::table('token_manage')->where('id', $tokenId)->first();

            if ($tokenData) {
                $this->tokenManage->setAttributes($tokenData);
                return $this->tokenManage;
            }
            return null;
        } catch (\Exception $e) {
            Log::info("Token Information Exception: " . $e->getMessage());
            return null;
        }
    }

     /**
      * Return List of tokens for a certain meter
     * @param $meterId
     * @return Token_manage|null
     * @author Julius
     */

     public function getInfoByMeterId($meterId)
     {
         try {
             $tokenData = DB::table('token_manage')->where('meter_id', $meterId)->get();

             if ($tokenData) {
                return $tokenData;
             }
             return null;
         } catch (\Exception $e) {
             Log::error("Token Information Exception: " . $e->getMessage());
             return null;
         }
     }


    /**
     * @param $token
     * @return Token_manage|null
     * @author Julius
     */

    public function getInfoByToken($token)
    {
        try {
            $tokenData = DB::table('token_manage')->where('token', $token)->first();

            if ($tokenData) {
                $this->tokenManage->setAttributes($tokenData);
                return $this->tokenManage;
            }
            return null;
        } catch (\Exception $e) {
            Log::error("Token Get Info Exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @param TokenManageDto $tokenManageDto
     * @return Token_manage|null
     * @author Julius
     */

     public function createManageInfo(TokenManageDto $tokenManageInfo)
     {
         try {
            $this->tokenManage->setAttributes($tokenManageInfo->getAttributes());
            $this->tokenManage->save();
            return $this->tokenManage;
         } catch (\Exception $e) {
           Log::error( "Token create Exception:". $e->getMessage());
           return null;
         }
     }

     /**
     * @param $meterId,requestId
     * @return Token_manage|null
     * @author Julius
     */

     public function getNotificationByRequestIdMeterNumber($meterId,$requestId)
     {

         try {
             $tokenData = DB::table('token_manage')->where('meter_id', $meterId)->where('requestId', $requestId)->get()->first();

             if ($tokenData) {
                 $this->tokenManage->setAttributes($tokenData);
                 return $this->tokenManage;
             }
             return null;
         } catch (\Exception $e) {
             Log::error("Token Information Exception: " . $e->getMessage());
             return null;
         }
     }
}
