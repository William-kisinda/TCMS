<?php

namespace App\Job;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\Tcms\Client\NotificationController;

/**
 *
 * @author Julius.
 *
 */


class GenerateToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $amount = null;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function handle()
    {
    try{
        $amount = $this->amount;

                // operations for debt will be handled here
        //check if the meter have debt
        

        // operations for tariff will be handled

        // Generate a unique token, we may add manipulation so as to generate unique token for each specific meter
        $token = $amount + 9 ;

        // Store token information in the 'tokens' table
        // Token::create([
        //     'token' => $token,
        //     'meter_id' => $user->meter,
        //     'generation_date' => now(), // You can customize the date format
        //     'amount' => $this->amount,
        //     'tariff_id' => $tariff->id,
        // ]);

        // Update the user's available units
        // $user->update([
        //     'available_units' => $user->available_units + $this->amount,
        // ]);

        // You can add any additional processing logic here

                //send Notification
                $client = new Client();

        $response = $client->request('POST', 'http://127.0.0.1:8000/api/token-receiver', [
            'query' => [
                'token' => $token,
             // Add other data you want to include in the notification here
         ],
        ]);
        Log::info( $response->getStatusCode());
        Log::info("reach here");
        Log::info($token);
    // Check if the notification was sent successfully

            // Dispatch a notification job to RabbitMQ queue
      //  Queue::connection('rabbitmq')->push(new SendNotification(NotificationController::class, 'sendNotification', [$token]));
    }catch (\Exception $exception) {
        // Log any exceptions or errors
        Log::error('Job failed: ' . $exception->getMessage());
    }
    }
}

