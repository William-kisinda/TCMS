<?php

namespace App;

class Helpers {
    //request and response ID generator
    function generateRequestId()
    {
        return date('YmdHis');
    }

    //Logname generator
    function generateLogName()
    {
        return date('Ymd');
    }

    //Generate Meter Number
    function generateMeterNumber($utility_provider_code) {
        $digitsNumberFromCode = substr($utility_provider_code, 2);
        $min = (10**7) + 1; // Smallest 8-digit number (10000000)
        $max = (10**8) - 1; // Largest 8-digit number (99999999)
        return $digitsNumberFromCode . random_int($min, $max);
    }

    //Generate Code
    function generateCode($contextName) {
        $min = (10**3) + 1; // Smallest 5-digit number (1001)
        $max = (10**4) - 1; // Largest 5-digit number (9999)
        $intCode = random_int($min, $max);

        //Take the first 2 characters of the name and append code to them and return the result.
        return strtoupper(substr($contextName, 0, 2)) . $intCode;
    }

    //Generate Meter Number
    function generateMeterToken($amount, $meterNumber, $requestId) {
        return intval($amount, 10) + $meterNumber + $requestId;
    }
}

// Additional custom helper functions can be defined here if needed
