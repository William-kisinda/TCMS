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
        $min = 10**11; // Smallest 12-digit number (100000000000)
        $max = (10**12) - 1; // Largest 12-digit number (999999999999)
        return random_int($min, $max);
    }
}

// Additional custom helper functions can be defined here if needed
