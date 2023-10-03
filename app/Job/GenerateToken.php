<?php

namespace App\Job;

use App\Helpers;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\controllers\tcmsDebt\Dto\DebtDto;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\tcmsDebt\Dao\DebtDaoImpl;
use App\Http\Controllers\Tcms\Client\NotificationController;
use App\Http\Controllers\Tcms\MeterValidation\Dto\ValidMeterDto;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;
use App\Http\Controllers\Tcms\TariffsManagement\Dao\TariffsDaoImpl;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDaoImp;
use App\Http\Controllers\Tcms\Debts\Dao\DebtDaoImpl as DaoDebtDaoImpl;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;

/**
 *
 * @author Julius.
 *
 */


class GenerateToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $amount ;
    protected $meterNumber ;
    protected $requestId ;
    protected $tariffs;

    public function __construct($amount, $meterNumber, $requestId,$tariffs)
    {
        $this->amount = $amount;
        $this->meterNumber = $meterNumber;
        $this->requestId = $requestId;
        $this->tariffs = $tariffs;
    }

    public function handle()
    {
    try{

                //validate meter number
       $meterDao = new MeterDaoImpl ;
       $meter = $meterDao->checkIfMeterExists($this->meterNumber);

    if($meter){

        //tariff codes for a moment until solution for tariff is obtained
        $tariffId = 1;

        //Handle Debt Operations
        // $debtDao = new DaoDebtDaoImpl();
        // $remaingAmount = $debtDao-> resolveDebt($this->meterNumber,$this->amount);
        // $newAmount = $remaingAmount['remainingAmount'];

        // operations for tariff will be handled
        $tariffDao = new TariffsDaoImpl();
        $amount = $this->amount;
        foreach ($this->tariffs as $tariff) {
            $amount1 = $tariffDao-> deductTariffByCode($tariff,$this->amount);
            $amount = $amount - floatval($amount1);
        }


        // Generate a unique token for each specific meter
        $token = intval($amount, 10) + $this->meterNumber + $this->requestId;

        //store token ManageInfo
        $tokenDto = new TokenManageDto();
        $tokenDto->setCreateInfo($token,$this->meterNumber, date('Ymd'), $tariffId);

        $tokenManageDao = new TokenManageDaoImp();
        $tokenManageDao->createManageInfo($tokenDto);
        

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
        Log::info($token,[' paid Amount after Tariffs: ', $amount]);
    // Check if the notification was sent successfully

            // Dispatch a notification job to RabbitMQ queue
      //  Queue::connection('rabbitmq')->push(new SendNotification(NotificationController::class, 'sendNotification', [$token]));
    } else{
        Log::info("Your Meter Number is Invalid", [" The request with Id: ", $this->requestId]);
    }
    }catch (\Exception $exception) {
        // Log any exceptions or errors
        Log::error('Job failed: ' . $exception->getMessage());
    }
    }
}

