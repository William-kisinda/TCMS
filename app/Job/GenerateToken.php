<?php

namespace App\Job;

use App\Helpers;
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
use App\Http\Controllers\Tcms\TariffsManagement\Dao\TariffsDaoImpl;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDaoImp;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;
use App\Http\Controllers\tcmsDebt\Dao\DebtDaoImpl;
use App\Http\controllers\tcmsDebt\Dto\DebtDto;

/**
 *
 * @author Julius.
 *
 */


class GenerateToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $amount = null;
    protected $meterId = null;

    public function __construct($amount, $meterId)
    {
        $this->amount = $amount;
        $this->meterId = $meterId;
    }

    public function handle()
    {
    try{
        $helpers = new Helpers();
        $amount = $this->amount;
        $meterId = $this->meterId;

        //parameters below will be fetched after meter validation including tariffs code
        $meterNumber = 0;
        $requestId = 0;
        //tariff codes
        $tariffCode = 'TN21';
        $tariffId = 1;

        //Handle Debt Operations
        $debtDao = new DebtDaoImpl();
        $remaingAmount = $debtDao-> resolveDebt($meterId,$amount);
        $newAmount = $remaingAmount['remainingAmount'];

        // operations for tariff will be handled
        $tariffDao = new TariffsDaoImpl();
        $finalAmount = $tariffDao-> deductTariffByCode($tariffCode,$newAmount);

        // Generate a unique token for each specific meter
        $token = intval($finalAmount, 10) + $meterNumber + $requestId;

        //store token ManageInfo
        $tokenDto = new TokenManageDto();
        $tokenDto->setCreateInfo($token,$meterId, date('Ymd'), $tariffId);

        $tokenManageDao = new TokenManageDaoImp();
        $tokenManageDao->createManageInfo($tokenDto);

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

