<?php

namespace App;

class ErrorCode
{
    const INVALID_INPUT = ['code' => 0001, 'description' => 'Invalid input data'];
    const DATABASE_ERROR = ['code' => 0002, 'description' => 'Database error'];
    const METERNUMBER_ERROR = ['code' => 0003, 'description' => 'Invalid Meter Number'];
    const SERVER_ERROR = ['code' => 0004, 'description' => 'An internal server error occurred. Please try your request again later.'];
    const REQUEST_SUCESS = ['code' => 0005, 'description' => 'request Accepted and procesed Successful'];
    
    // Add more error codes and descriptions as needed
}
