<?php

namespace App\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDaoImp;

/**
 * This is the job that save token manage info to the database
 * @author Julius.
 *
 */

class TokenManage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tokenInfo;


    public function __construct($tokenInfo)
    {
        $this->tokenInfo = $tokenInfo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

            //This is just save the information to the database
        $tokenManageDao = new TokenManageDaoImp();
        $tokenManageDao->createManageInfo($this->tokenInfo);

            // Check if the notification was sent successfully
        Log::info("Token Info saved Sucessful");

    }
}
