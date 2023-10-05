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

<<<<<<< HEAD:app/Http/Controllers/tcmsDebt/Dao/DebtDaoImpl.php
    public function assignDebtByMeterId($meterId, $AssigneDebtAmount, $AssignedReductionRate, $description)
    {
        $description=(string) $description;

            // Check if there is already an existing debt for the meter
            $existingDebt = Debt::where('meters_id', $meterId)->first();

            // if ($existingDebt) {

            //     //   $CurentdebtAmount=$existingDebt->debtAmount + $AssigneDebtAmount;
            //     // Example: Update the existing debt with new values
            //     $existingDebt->debtAmount = $CurentdebtAmount;
            //     $existingDebt->reductionRate = $AssignedReductionRate;
            //     $existingDebt->description=$description;
            //     $existingDebt->save();

            //     return [
            //         'meterExists' => true,
            //         'debtAmount' => $CurentdebtAmount,
            //         'debtReduction' => $AssignedReductionRate,
            //         'description'=> $description,
            //         // 'remainingAmount'=>$remainingAmount

            //     ];
            // }

            // else {
                // If there is no existing debt, create a new debt record
                $newDebt = new Debt();
                $newDebt->meters_id = $meterId;
                $newDebt->debtAmount = $AssigneDebtAmount;
                $newDebt->remainingDebtAmount = $AssigneDebtAmount;
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

public function resolveDebt($meterId, $amount)
{
    // Validate the input data
    $amount = (float) $amount;
    $debtReduction = 0.0;

    $debts = Debt::where('meters_id', $meterId);

    if ( $debts->get()->isEmpty() ) {
        return $this->returnResponse(['meterExists' => false, 'error' => true, 'reason' => 'Reason meter { ' . $meterId . ' } does not exist in debts table']);
=======


    public function resolveDebt($meterId, $amount)
    {
        // Validate the input data
        $amount = (float) $amount;
        $remainingAmount = 0.0;
        $debtReduction = 0.0;

        // Retrieve the meter based on the provided meterNumber
        $meter = Meter::where('id', $meterId)->first();

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
>>>>>>> 8e42acead3aabb4a056b1709e83e3a3f10bc93f2:app/Http/Controllers/Tcms/Debts/Dao/DebtDaoImpl.php
    }

    $debts = $debts->where('remainingDebtAmount' , '!=' , 0)->orderBy('created_at', 'asc')
    ->get();

    if ($debts->isEmpty()) {
        return $this->returnResponse(['meterExists' => true, 'error' => false, 'remainingAmount' => $amount]);
    }

    $reductionRate = $debts[0]->reductionRate;
    $debtReduction = $amount * $reductionRate / 100 ;
    $remainingAmount = $amount - $debtReduction;

    if ($debts[0]->remainingDebtAmount >= $debtReduction) {
        return $this->maxDebtMinReduction( 0, $debts, $debtReduction, $remainingAmount );
        } else {
            return $this->minDebtMaxReduction( $debts, $debtReduction, $remainingAmount );
        }
    }

        public function maxDebtMinReduction( $index, $debts, $debtReduction, $remainingAmount ){
            $debts[ $index ]->remainingDebtAmount -= $debtReduction;
            $debts[ $index ]->save();
            return $this->returnResponse(['meterExists' => true, 'error' => false, 'remainingAmount' => $remainingAmount]);
        }

        public function minDebtMaxReduction( $debts, $debtReduction, $remainingAmount ){
            $row = 0;
            do{
                if( $debts[ $row ]->remainingDebtAmount >= $debtReduction ){
                    return $this->maxDebtMinReduction( $row, $debts, $debtReduction, $remainingAmount );
                    }
                    $debtReduction  -=  $debts[ $row ]->remainingDebtAmount;
                    $debts[ $row ]->remainingDebtAmount = 0;
                    $debts[ $row ]->save();
                    $row++;

            }while( $debtReduction !== 0 && count( $debts ) - 1 >= $row );

<<<<<<< HEAD:app/Http/Controllers/tcmsDebt/Dao/DebtDaoImpl.php
            return $this->returnResponse(['meterExists'=>true, 'error' => false, 'remainingAmount' => $remainingAmount + $debtReduction]);
        }

        public function returnResponse($response){

            if( $response['error'] ){
                return [
                    'error' => $response['error'],
                    'meterExists'=>$response['meterExists'],
                    'reason' => $response['reason'],
                ];
            }

            return [
                'error' => $response['error'],
                'meterExists'=>$response['meterExists'],
                'remainingAmount' => $response['remainingAmount'],
            ];

        }

=======
>>>>>>> 8e42acead3aabb4a056b1709e83e3a3f10bc93f2:app/Http/Controllers/Tcms/Debts/Dao/DebtDaoImpl.php
    public function getDebtByMeterId($meterId)
    {
        try {
            // Retrieve the debt for the meter using the meter_id
            $meter = Meter::find($meterId);

<<<<<<< HEAD:app/Http/Controllers/tcmsDebt/Dao/DebtDaoImpl.php
            $debt = Debt::select('debtAmount', 'reductionRate' ,'remainingAmount',)
=======
            $debt = Debt::select('amount', 'reductionRate')
>>>>>>> 8e42acead3aabb4a056b1709e83e3a3f10bc93f2:app/Http/Controllers/Tcms/Debts/Dao/DebtDaoImpl.php
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
