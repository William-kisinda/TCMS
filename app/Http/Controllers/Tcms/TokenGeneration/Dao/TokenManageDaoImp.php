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
            if (!blank($tokenData)) {

                $tokenDataArray = json_decode(json_encode($tokenData), true);

                $$this->tokenManage->setAttributes($tokenDataArray);
            }
        } catch (\Exception $exception) {
            Log::info("Token Information Exception:" . $exception->getMessage());
        }
        return $this->tokenManage;
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

            if (!empty($tokenData)) {
                // If the token info is found, you can directly create a Token_manage object.
                $this->tokenManage->setAttributes((array) $tokenData);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Token Information Exception: " . $e->getMessage());
        }

        return $this->tokenManage;
    }

     /**
     * @param $meterId
     * @return Token_manage|null
     * @author Julius
     */

     public function getInfoByMeterId($meterId)
     {

         try {
             $tokenData = DB::table('token_manage')->where('meter_id', $meterId)->get();

             if (!empty($tokenData)) {
                 // If the token info is found, you can directly create a Token_manage object.
                 $tokenDataArray = json_decode(json_encode($tokenData), true);

                 $this->tokenManage->setAttributes($tokenDataArray);
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::info("Token Information Exception: " . $e->getMessage());
         }

         return $this->tokenManage;
     }


    /**
     * @param $token
     * @return Token_manage|null
     * @author Julius
     */

    public function getInfoByToken($token)
    {
        $tokenInfo = null;

        try {
            $tokenData = DB::table('token_manage')->where('token', $token)->first();

            if (!empty($tokenData)) {
                // If the token info is found, you can directly create a Token_manage object.
                $tokenInfo = new Tariffs();
                $tokenInfo->setAttributes((array) $tokenData);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Token Get Info Exception: " . $e->getMessage());
        }

        return $tokenInfo;
    }

    /**
     * @param TokenManageDto $tokenManageDto
     * @return Token_manage|null
     * @author Julius
     */

     public function createManageInfo(TokenManageDto $tokenManageInfo)
     {
         try {
            $tokenManage = new Token_manage();
            $tokenManage->setAttributes($tokenManageInfo->getAttributes());

            $tokenManage->save();
         } catch (\Exception $e) {
            $tokenInfo = null;
            Log::info("Token create Exception:". $e->getMessage());
         }
         return $tokenManage;
     }

     /**
     * @param $meterId
     * @return Token_manage|null
     * @author Julius
     */

     public function getNotificationByRequestIdMeterNumber($meterId,$requestId)
     {

         try {
             $tokenData = DB::table('token_manage')->where('meter_id', $meterId)->where('requestId', $requestId)->get();

             if (!empty($tokenData)) {
                 // If the token info is found, you can directly create a Token_manage object.
                 $tokenDataArray = json_decode(json_encode($tokenData), true);

                 $this->tokenManage->setAttributes($tokenDataArray);
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::info("Token Information Exception: " . $e->getMessage());
         }

         return $this->tokenManage;
     }
}
