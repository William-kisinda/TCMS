<?php

namespace App\Http\Controllers\tcmsDebt\Dao;

use App\Models\Debt;
use App\Models\Meter;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpResponse;
use App\Http\controllers\tcmsDebt\Dao\DebtDao;

/**
 *
 * @author Hamphrey Urio.
 *
 */



class DebtDaoImpl implements DebtDao
{


    public function resolveDebt($meterId, $amount)
    {
        // Validate the input data
        $amount = (float) $amount;
        $remainingAmount = 0.0;
        $debtReduction = 0.0;

        // Retrieve the meter based on the provided meterNumber
        $meter = Meter::where('meters_id', $meterId)->first();

        // Check if the meter exists
        if (!$meter) {
            return [
                'meterExists' => false,
                'remainingAmount' => $amount,
                'debtReduction' => $debtReduction,
                'remainingdebt' => 0
            ];

        }

        // Retrieve the debt for the meter using the meter_id
        $debt = Debt::where('meters_id', $meter->id)->first();

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

            $debt = Debt::select('debtAmount', 'reductionRate')
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
