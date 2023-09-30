<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Dao;

use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;

/**
 * This interface Access Token Management Data
 * @author Julius.
 *
 */

interface TokenManageDao
{
    public function getAllInfo();
    public function getInfoById($tokenId);
    public function getInfoByMeterId($meterId);
    public function getInfoByToken($token);
   // public function getInfoByDate($date);
   // public function getInfoByDateAndMeterId($date, $meterId);
    public function createManageInfo(TokenManageDto $tokenManageInfo);
}
