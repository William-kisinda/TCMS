<?php

namespace App\Http\Controllers\Tcms\Debts\Dao;

use App\Models\Debt;
use App\Models\Meter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\Debts\Dao\DebtDao;
use App\Http\Controllers\Tcms\Debts\Dto\DebtDto;

/**
 *
 * @author Hamphrey Urio.
 *
 */



class DebtDaoImpl implements DebtDao
{
    public function assignDebt(DebtDto $debtDto, $update = false) {
        $debt = null;
        try {
            $debt = new Debt();

            if(!$update) {
                $debt->setAttributes($debtDto->getAttributes());
                $debt->save();
            } else {
                $debtInfo = Debt::where('meters_id', $debtDto->getDebt_meters_id())->first();
                Log::info("Debt Info:". json_encode($debtDto->getAttributes()));
                $prevDebtAmount = $debtInfo->amount;
                $newDebtAmount = $debtDto->getDebt_amount();
                $totalDebtAmount = $prevDebtAmount + $newDebtAmount;
                Log::info("Debt Total:". $totalDebtAmount);
                $debtDto->setDebt_amount($totalDebtAmount);
                $debt->setAttributes($debtDto->getAttributes());
                Log::info("Debt Update Info:". json_encode($debt->getAttributes()));
                $debtInfo->amount = $totalDebtAmount;
                $debtInfo->update();
            }
        } catch (\Exception $e) {
            $debt = null;
            Log::info("Debt assign Exception:". $e->getMessage());
        }
        return $debt;
    }

    public function assignDebtByMeterId($meterId, $AssigneDebtAmount, $AssignedReductionRate,$description)
    {
        $description=(string) $description;

            // Check if there is already an existing debt for the meter
            $existingDebt = Debt::where('meters_id', $meterId)->first();

            if ($existingDebt) {

                  $CurentdebtAmount=$existingDebt->debtAmount + $AssigneDebtAmount;
                // Example: Update the existing debt with new values
                $existingDebt->debtAmount = $CurentdebtAmount;
                $existingDebt->reductionRate = $AssignedReductionRate;
                $existingDebt->description=$description;
                $existingDebt->save();

                return [
                    'meterExists' => true,
                    'debtAmount' => $CurentdebtAmount,
                    'debtReduction' => $AssignedReductionRate,
                    'description'=> $description,

                ];
            }

            else {
                // If there is no existing debt, create a new debt record
                $newDebt = new Debt();
                $newDebt->meters_id = $meterId;
                $newDebt->debtAmount = $AssigneDebtAmount;
                $newDebt->reductionRate =$AssignedReductionRate ;
                $newDebt->description=$description;

                $newDebt->save();

                return [
                    'meterExists' => true,
                    'debtAmount' => $AssigneDebtAmount,
                    'debtReduction' => $AssignedReductionRate,
                    'description'=> $description,
                ];
            }
        }




    public function resolveDebt($meterId, $amount)
{
    // Validate the input data
    $amount = (float) $amount;
    $remainingAmount = 0.0;
    $debtReduction = 0.0;

    // Retrieve the meter based on the provided meterId
    $meter = Meter::find($meterId);


    // Retrieve the debt for the meter using the meter_id
    $debt = Debt::where('meters_id', $meterId)->first();

    // Check if there is a debt record for the meter
    if (!$debt) {
        return [
            'meterExists' => true,
            'remainingAmount' => $amount,
            'debtReduction' => Null,
            'remainingdebt' => null
        ];
    }
   else
   {

    $reductionRate = $debt->reductionRate; // Convert percentage to decimal
    $debtReduction = $amount * ($reductionRate / 100);

    if ($debtReduction >= $debt->debtAmount) {
        $remainingAmount = $amount - $debt->debtAmount;

        Debt::where('meters_id', $meterId)->delete();
        $debt->update();

        return [
            'meterExists' => true,
            'remainingAmount' => $remainingAmount,
            'debtReduction' => $debtReduction,
            'remainingdebt' => 0
        ];
    }
     else
     {
    // Calculate the remaining amount after paying the debt
    $remainingAmount = $amount - $debtReduction;
    $remainingdebt = $debt->debtAmount - $debtReduction;
    if ($remainingdebt == 0) {
        // Delete the row with specific meters_id if remainingdebt is 0

        Debt::where('meters_id', $meterId)->delete();
    } else {
        $debt->debtAmount = $remainingdebt;
        $debt->update();
    }



    return [
        'meterExists' => true,
        'remainingAmount' => $remainingAmount,
        'debtReduction' => $debtReduction,
        'remainingdebt' => $remainingdebt,
    ];
}}
}

    public function getDebtByMeterId($meterId)
    {
        try {
            // Retrieve the debt for the meter using the meter_id

            $debt = Debt::select('amount', 'reductionRate')
                ->where('meters_id', $meterId)
                ->first();

            return $debt;
        } catch (\Exception $e) {
            // Handle any exceptions or errors here
            Log::error("Error fetching debt: " . $e->getMessage());
            return null; // You can return null or handle the error as needed
        }
    }
}
