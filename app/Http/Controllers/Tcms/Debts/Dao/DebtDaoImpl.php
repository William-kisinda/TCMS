<?php

namespace App\Http\Controllers\Tcms\Debts\Dao;

use App\Models\Debt;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\Debts\Dao\DebtDao;

/**
 *
 * @author Hamphrey Urio.
 *
 */

class DebtDaoImpl implements DebtDao
{
    public function assignDebtByMeterId($meterId, $AssigneDebtAmount, $AssignedReductionRate, $description)
    {
        $description = (string) $description;
        $newDebt = app(Debt::class);
        $newDebt->meters_id = $meterId;
        $newDebt->debtAmount = $AssigneDebtAmount;
        $newDebt->remainingDebtAmount = $AssigneDebtAmount;
        $newDebt->reductionRate = $AssignedReductionRate;
        $newDebt->description = $description;

        $newDebt->save();

        return [
            'meterExists' => true,
            'debtAmount' => $AssigneDebtAmount,
            'debtReduction' => $AssignedReductionRate,
            'description' => $description,
        ];
    }

    public function resolveDebt($meterId, $amount)
    {
        // Validate the input data
        $amount = (float) $amount;
        $debtReduction = 0.0;

        $debts = Debt::where('meters_id', $meterId);

        if ($debts->get()->isEmpty()) {
            // return $this->returnResponse(['meterExists' => false, 'error' => true, 'reason' => 'Reason meter { ' . $meterId . ' } does not exist in debts table']);
            return $this->returnResponse(['meterExists' => true, 'error' => false, 'remainingAmount' => $amount]);
        }

        $debts = $debts->where('remainingDebtAmount', '!=', 0)->orderBy('created_at', 'asc')
            ->get();

        if ($debts->isEmpty()) {
            return $this->returnResponse(['meterExists' => true, 'error' => false, 'remainingAmount' => $amount]);
        }

        $reductionRate = $debts[0]->reductionRate;
        $debtReduction = $amount * $reductionRate / 100;
        $remainingAmount = $amount - $debtReduction;

        if ($debts[0]->remainingDebtAmount >= $debtReduction) {
            return $this->maxDebtMinReduction(0, $debts, $debtReduction, $remainingAmount);
        } else {
            return $this->minDebtMaxReduction($debts, $debtReduction, $remainingAmount);
        }
    }

    public function maxDebtMinReduction($index, $debts, $debtReduction, $remainingAmount)
    {
        $debts[$index]->remainingDebtAmount -= $debtReduction;
        $debts[$index]->save();
        return $this->returnResponse(['meterExists' => true, 'error' => false, 'remainingAmount' => $remainingAmount]);
    }

    public function minDebtMaxReduction($debts, $debtReduction, $remainingAmount)
    {
        $row = 0;
        do {
            if ($debts[$row]->remainingDebtAmount >= $debtReduction) {
                return $this->maxDebtMinReduction($row, $debts, $debtReduction, $remainingAmount);
            }
            $debtReduction  -=  $debts[$row]->remainingDebtAmount;
            $debts[$row]->remainingDebtAmount = 0;
            $debts[$row]->save();
            $row++;
        } while ($debtReduction !== 0 && count($debts) - 1 >= $row);

        return $this->returnResponse(['meterExists' => true, 'error' => false, 'remainingAmount' => $remainingAmount + $debtReduction]);
    }

    public function returnResponse($response)
    {
        if ($response['error']) {
            return [
                'error' => $response['error'],
                'meterExists' => $response['meterExists'],
                'reason' => $response['reason'],
            ];
        }
        return [
            'error' => $response['error'],
            'meterExists' => $response['meterExists'],
            'remainingAmount' => $response['remainingAmount'],
        ];
    }

    public function getDebtByMeterId($meterId)
    {
        try {
            // Retrieve the debt for the meter using the meter_id
            $debt = Debt::select('remainingDebtAmount', 'reductionRate', 'description', 'debtAmount')
                ->where('meters_id', $meterId)
                ->get();

            return $debt;
        } catch (\Exception $e) {
            // Handle any exceptions or errors here
            Log::error("Error fetching debt: " . $e->getMessage());
            return null; // You can return null or handle the error as needed
        }
    }
}
