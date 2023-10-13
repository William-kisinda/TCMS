<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\Helpers;
use GuzzleHttp\Client;
use App\Job\TokenManage;
use App\Job\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\Tcms\Debts\Dao\DebtDaoImpl;
use App\Http\Controllers\Tcms\Meters\Dao\MeterDaoImpl;
use App\Http\Controllers\Tcms\TokenGeneration\Dto\TokenManageDto;
use App\Http\Controllers\Tcms\TariffsManagement\Dao\TariffsDaoImpl;
use App\Http\Controllers\Tcms\TokenGeneration\Dao\TokenManageDaoImp;
use App\Models\Notifications;

/**
 *
 * @author Julius.
 *
 */

class GenerateToken
{
    protected $amount;
    protected $meterNumber;
    protected $requestId;
    protected $utility_provider;
    protected $errorIfAny;

    public function __construct($amount, $meterNumber, $requestId, $utility_provider)
    {
        $this->amount = $amount;
        $this->meterNumber = $meterNumber;
        $this->requestId = $requestId;
        $this->utility_provider = $utility_provider;
        $this->errorIfAny = false;
    }

    public function generateToken()
    {
        try {

            //validate meter number
            $meterDao = new MeterDaoImpl;
            $meter = $meterDao->checkIfMeterExists($this->meterNumber);
            if ($meter) {

                //tariff codes for a moment until solution for tariff is obtained
                $tariffId = 1;

                // Handle Debt Operations
                $debtDao = new DebtDaoImpl();
                $debtResolved = $debtDao->resolveDebt($meter->getMeterId(), $this->amount);
                $newAmount = $debtResolved['remainingAmount'];
                $this->amount = $newAmount;

                // Deduct Tariffs
                //Get tariffs assosciated with this provider.
                $utilityProviderTariffAmounts = [];
                $tariffDao = new TariffsDaoImpl();
                $tariffsData = $tariffDao->getTariffsByUtilityProvider($this->utility_provider);
                $tariffsDataArray = json_decode(json_encode($tariffsData));
                $tariffsArray = json_decode(json_encode($tariffsDataArray[0]));
                $tariffs = $tariffsArray->tariffs;
                foreach ($tariffs as $tariff) {
                    array_push($utilityProviderTariffAmounts, $tariff->percentageAmount);
                }
                
                $amount = $this->amount;

                foreach ($utilityProviderTariffAmounts as $tariffAmount) {
                    // $amount1 = $tariffDao->deductTariffByCode($tariffCode, $this->amount);
                    $tariffedAmount = (($amount*$tariffAmount)/100);

                    $amount = $amount - floatval($tariffedAmount);
                }

                // Log::info("Tariff Amounts ".json_encode($utilityProviderTariffAmounts));
                // Log::info("Final Amount ". $amount);
                // Generate a unique token for each specific meter
                $helpers = new Helpers();
                
                $token = $helpers->generateMeterToken($amount, $this->meterNumber, $this->requestId);

                //store token ManageInfo
                $tokenDto = new TokenManageDto();

                $tokenDto->setCreateInfo($token, $meter->getMeterId(), date('Ymd'), $tariffId);

                // Dispatch the job for saving info to database to the RabbitMQ queue
                // TokenManage::dispatch($tokenDto)->onQueue('dbSave');
                $tokenManageDao = new TokenManageDaoImp();
                $token_manage = $tokenManageDao->createManageInfo($tokenDto);

                if (!is_null($token_manage)) {
                    Log::info("Token Info saved Sucessful!");
                } else {
                    $this->errorIfAny = true;
                }

                if (!$this->errorIfAny) {
                    // Dispatch the send notification job to the RabbitMQ queue
                    // $endUrl = 'http://127.0.0.1:8000/api/token-receiver';
                    // //SendNotification::dispatch($token, $endUrl)->onQueue('notification');
                    // try {
                    //     $client = new Client();
                    //     $response = $client->request('POST', $endUrl, [
                    //         'query' => [
                    //             'token' => $token,
                    //             // other data will be added here
                    //         ],
                    //     ]);
                    //     Log::info("notification send and received sucessful: " . $response->getStatusCode());
                    //     Log::info($token, ['Paid Amount after Tariffs: ', $amount]);
                    // } catch (\Exception $exception) {
                    //     // Log any exceptions or errors
                    //     $this->errorIfAny = true;
                    //     Log::error('Notification task failed: ' . $exception->getMessage());
                    // }
                    try {
                        $notification = Notifications::create([
                            'token' => $token,
                            'meternumber' => $this->meterNumber,
                        ]);
                        if($notification) {
                            Log::info("notification send and received sucessful: ");
                            Log::info($token, ['Paid Amount after Tariffs: ', $amount]);
                        }
                        
                    } catch(\Exception $exception) {
                        Log::error('Notification save failed: ' . $exception->getMessage());
                    }
                } else {
                    Log::info("Token info could not be saved successfully.");
                }
            } else {
                Log::info("Your Meter Number is Invalid", [" The request with Id: ", $this->requestId]);
            }
        } catch (\Exception $exception) {
            // Log any exceptions or errors
            $this->errorIfAny = true;
            // Log::info("Debt Resolved: ".json_encode($debtResolved));
            Log::error('Job failed: ' . $exception->getMessage());
        }
        return array($this->errorIfAny, $this->requestId);
    }
}
