<?php
namespace App\Http\Controllers\Tcms\ValidationRequest\Dao;

use App\Http\Controllers\Tcms\ValidationRequest\Dto\ValidationDto;

/**
 * This interface Access IdentityType Data
 * @author Daniel MM.
 *
 */

 interface ValidationDao {
    public function validateIdFromRequest(ValidationDto $validationDto);
 }

?>