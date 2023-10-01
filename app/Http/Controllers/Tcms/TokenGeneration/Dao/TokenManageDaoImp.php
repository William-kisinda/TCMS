<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Dao;

use App\Models\Tariffs;
use App\Models\Token_manage;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDao;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;

/**
 * This Class is for Token Information data access
 * @author Julius.
 *
 */

class TokenManageDaoImp implements TokenManageDao
{
    /**
     * @param null
     * @return array|null
     * @author Julius
     */
    public function getAllInfo()
    {
        $tokenInfo = null;
        try {
            $tokenData = DB::table('token_manage')->get();
            if (!blank($tokenData)) {

                $tokenDataArray = json_decode(json_encode($tokenData), true);

                $tokenInfo = new Token_manage();

                $tokenInfo->setAttributes($tokenDataArray);
            }
        } catch (\Exception $exception) {
            Log::info("Token Information Exception:" . $exception->getMessage());
        }
        return $tokenInfo;
    }

    /**
     * @param $tokenId
     * @return Token_manage|null
     * @author Julius
     */

    public function getInfoById($tokenId)
    {
        $tokenInfo = null;

        try {
            $tokenData = DB::table('token_manage')->where('id', $tokenId)->first();

            if (!empty($tokenData)) {
                // If the token info is found, you can directly create a Token_manage object.
                $tokenInfo = new Token_manage();
                $tokenInfo->setAttributes((array) $tokenData);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::info("Token Information Exception: " . $e->getMessage());
        }

        return $tokenInfo;
    }

     /**
     * @param $meterId
     * @return Token_manage|null
     * @author Julius
     */

     public function getInfoByMeterId($meterId)
     {
         $tokenInfo = null;

         try {
             $tokenData = DB::table('token_manage')->where('meter_id', $meterId)->get();

             if (!empty($tokenData)) {
                 // If the token info is found, you can directly create a Token_manage object.
                 $tokenDataArray = json_decode(json_encode($tokenData), true);

                $tokenInfo = new Token_manage();

                $tokenInfo->setAttributes($tokenDataArray);
             }
         } catch (\Exception $e) {
             // Log the exception for debugging purposes.
             Log::info("Token Information Exception: " . $e->getMessage());
         }

         return $tokenInfo;
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
            Log::info("Tariff Exception: " . $e->getMessage());
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
         $tokenInfo = null;
         try {
             $tokenInfo = new Tariffs();

             $tokenInfo->setAttributes($tokenManageInfo->getAttributes());

             $tokenInfo->save();
         } catch (\Exception $e) {
             Log::info("Tariff Exception:". $e->getMessage());
         }
         return $tokenInfo;
     }
}
