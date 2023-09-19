<?php

namespace App\Http\Controllers;

use App\Models\Meters;
use Illuminate\Http\Request;

class MeterValidationController extends Controller
{
    public function validateMeter($meterNumber){
        //find the meter number from the meter table
        $meter = Meters::where('meterNumber', $meterNumber)->first();

        if(!$meter){
            return response()->json(['Error' => 'Meter Not Found'] , 404);
        }

        //retrieve the full meter information
        $customer = $meter -> customer;

        return response()->json([
            'works'
        ]);
    }
}
