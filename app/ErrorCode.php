<?php

namespace App;

class ErrorCode
{
    const INVALID_INPUT = ['code' => 1001, 'description' => 'Invalid input data'];
    const DATABASE_ERROR = ['code' => 1002, 'description' => 'Database error'];
    const METERNUMBER_ERROR = ['code' => 1003, 'description' => 'Invalid Meter Number'];
    const SERVER_ERROR = ['code' => 1004, 'description' => 'An internal server error occurred. Please try your request again later.'];
    const REQUEST_SUCESS = ['code' => 1005, 'description' => 'request Accepted and procesed Successful'];
    // Add more error codes and descriptions as needed
}
