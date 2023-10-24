<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Api;

use App\Helpers;
use Illuminate\Support\Facades\Log;
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
    private $amount;
    private $meterNumber;
    private $requestId;
    private $utility_provider;
    private $errorIfAny;


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
            $meterDao = app(MeterDaoImpl::class);
            $meter = $meterDao->checkIfMeterExists($this->meterNumber);
            if ($meter) {

                // Handle Debt Operations
                $debtDao = app(DebtDaoImpl::class);
                $debtResolved = $debtDao->resolveDebt($meter->getMeterId(), $this->amount);
                $newAmount = $debtResolved['remainingAmount'];
                $this->amount = $newAmount;

                // Deduct Tariffs
                //Get tariffs assosciated with this provider.
                $utilityProviderTariffAmounts = [];
                $tariffDao = app(TariffsDaoImpl::class);
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
                $helpers = app(Helpers::class);

                $token = $helpers->generateMeterToken($amount, $this->meterNumber, $this->requestId);

                //store token ManageInfo
                $tokenDto = app(TokenManageDto::class);

                $tokenDto->setCreateInfo($token, $meter->getMeterId(), date('Ymd'));

                // Dispatch the job for saving info to database to the RabbitMQ queue
                // TokenManage::dispatch($tokenDto)->onQueue('dbSave');
                $tokenManageDao = app(TokenManageDaoImp::class);
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
