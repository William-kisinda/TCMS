<?php

namespace App\Job;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * This is the job that send Notification
 * @author Julius.
 *
 */

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $token;
    protected $endUrl;


    public function __construct($token, $endUrl)
    {
        $this->token = $token;
        $this->endUrl = $endUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{

            $client = new Client();
            $response = $client->request('POST', $this->endUrl, [
                'query' => [
                    'token' => $this->token,
                 // other data will be added here
             ],
            ]);

            Log::info( $response->getStatusCode());
            Log::info("notification send and received sucessful");

        }catch (\Exception $exception) {

        // Log any exceptions or errors
        Log::error('Job failed: ' . $exception->getMessage());

    }
    }
}
