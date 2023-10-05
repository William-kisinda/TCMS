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
    function generateMeterNumber() {
        $min = (10**11) + 1; // Smallest 12-digit number (100000000001)
        $max = (10**12) - 1; // Largest 12-digit number (999999999999)
        return random_int($min, $max);
    }

    //Generate Code
    function generateCode($contextName) {
        $min = (10**3) + 1; // Smallest 5-digit number (1001)
        $max = (10**4) - 1; // Largest 5-digit number (9999)
        $intCode = random_int($min, $max);

        //Take the first 2 characters of the name and append code to them and return the result.
        return strtoupper(substr($contextName, 0, 2)) . $intCode;
    }
}

// Additional custom helper functions can be defined here if needed
