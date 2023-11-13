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
    private $utilityProvider;
    private $errorIfAny;
    private $requestTime;
    protected $partnersCode;
    protected $requestId;


    public function __construct($amount, $meterNumber, $utilityProvider, $requestTime, $partnersCode, $requestId)
    {
        $this->amount = $amount;
        $this->meterNumber = $meterNumber;
        $this->utilityProvider = $utilityProvider;
        $this->requestTime = $requestTime;
        $this->partnersCode = $partnersCode;
        $this->requestId = $requestId;
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
                $tariffsData = $tariffDao->getTariffsByUtilityProvider($this->utilityProvider);
                $tariffsDataArray = json_decode(json_encode($tariffsData));
                $tariffsArray = json_decode(json_encode($tariffsDataArray[0]));
                $tariffs = $tariffsArray->tariffs;
                foreach ($tariffs as $tariff) {
                    array_push($utilityProviderTariffAmounts, $tariff->percentageAmount);
                }

                $amount = $this->amount;

                foreach ($utilityProviderTariffAmounts as $tariffAmount) {
                    // $amount1 = $tariffDao->deductTariffByCode($tariffCode, $this->amount);
                    $tariffedAmount = (($this->amount*$tariffAmount)/100);
                    $amount = $amount - floatval($tariffedAmount);
                }

                // Generate a unique token for each specifrr
                $helpers = app(Helpers::class);
                $token = $helpers->generateMeterToken($amount, $this->meterNumber, $this->requestId);

                //store created token Info to the database
                $tokenDto = app(TokenManageDto::class);
                $tokenManageDao = app(TokenManageDaoImp::class);
                $tokenInfo = $tokenDto->newTokenInfo($token, $meter->getMeterId(), now(),$this->utilityProvider,$this->requestId,$this->requestTime,$this->partnersCode);// require to extract partner Id from partner code
                $token_manage = $tokenManageDao->createManageInfo($tokenInfo);

                //check if data is saved successful to the Database
                if ($token_manage) {
                   Log::channel('custom_daily')->info("\nToken Information with Request ID: ".$this->requestId." saved Sucessful!\n With the Information : ".json_encode($token_manage)."\n that can be successful accessed with the user for his notification");
                } else {
                    $this->errorIfAny = true;
                    Log::channel('custom_daily')->error("Token operation with the request ID: ".$this->requestId ."The Data failed to be saved to the database");
                }

            } else {
                $this->errorIfAny = true;
                Log::channel('custom_daily')->info("\nInvalid Meter Number , The request with Id : ". $this->requestId." , He/she might try to harm the system");
            }
        } catch (\Exception $exception) {
            // Log any exceptions or errors
            $this->errorIfAny = true;
            Log::channel('custom_daily')->error('\nJob failed: ' . $exception->getMessage());
        }
        return array($this->errorIfAny, $this->requestId);
    }

}
