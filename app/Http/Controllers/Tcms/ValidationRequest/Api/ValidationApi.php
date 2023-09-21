<?php

namespace App\Http\Controllers\Tcms\ValidationRequest\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * This Class Controls Validation API
 * @author Mathew Daniel.
 * Email:danielmathew460@gmail.com
 * 31/08/2023
 *
 */

/**
 * Validation API controller
 */
class ValidationApi extends Controller
{
    /**
     * ValidationController constructor.
     */
    public function __construct()
    {
        $num = 1;
    }

    public function getIdFromRequest(Request $request)
    {
    }
}
