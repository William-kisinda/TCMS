<?php

namespace App\Job;




use App\Job\TokenManage;
use App\Job\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;
use App\Http\Controllers\Tcms\TariffsManagement\Dao\TariffsDaoImpl;

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



            // Deduct Tariff
        $tariffDao = new TariffsDaoImpl();
        $amount = $this->amount;
        $tariffs = ['TN21','EW342'];
        foreach ($tariffs as $tariff) {
            $amount1 = $tariffDao-> deductTariffByCode($tariff,$this->amount);
            $amount = $amount - floatval($amount1);
        }




            // Generate a unique token for each specific meter
        $token = intval($amount, 10) + $this->meterNumber + $this->requestId;



            // Dispatch the send notification job to the RabbitMQ queue
        $endUrl = 'http://127.0.0.1:8000/api/token-receiver';
        SendNotification::dispatch($token,$endUrl)->onQueue('notification');



                //store token ManageInfo
        $tokenDto = new TokenManageDto();
        $tokenDto->setCreateInfo($token,$this->meterNumber, date('Ymd'), $tariffId);

            // Dispatch the job for saving info to database to the RabbitMQ queue
        TokenManage::dispatch($tokenDto)->onQueue('dbSave');



            // Check if the notification was sent successfully
        Log::info("reach here");
        Log::info($token,[' paid Amount after Tariffs: ', $amount]);

    } else{
        Log::info("Your Meter Number is Invalid", [" The request with Id: ", $this->requestId]);
    }
    }catch (\Exception $exception) {
        // Log any exceptions or errors
        Log::error('Job failed: ' . $exception->getMessage());
    }
    }
}

