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
}

// Additional custom helper functions can be defined here if needed
