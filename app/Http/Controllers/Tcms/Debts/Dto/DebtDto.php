<?php

namespace App\Http\Controllers\Tcms\Debts\Dto;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class DebtDto
{
    use HasAttributes;

    public function SetDebtDto($id, $description, $debtAmount, $reductionRate, $metersId)
    {
        $this->attributes = [];

        $this->attributes['id'] = $id;

        $this->attributes['amount'] = $debtAmount;

        $this->attributes['description'] = $description;

        $this->attributes['reductionRate'] = $reductionRate;
        
        $this->attributes['meters_id'] = $metersId;

        return $this->attributes;
    }

    public function getDebt_Id()
    {
        return  $this->attributes['id'];
    }

    public function setDebt_Id($debt_id)
    {
        $this->attributes['id'] = $debt_id;
    }

    public function getDebt_description()
    {
        return  $this->attributes['description'];
    }

    public function setDebt_description($debt_description)
    {
        $this->attributes['description'] = $debt_description;
    }

    public function getDebt_amount()
    {
        return  $this->attributes['amount'];
    }

    public function setDebt_amount($debt_amount)
    {
        $this->attributes['amount'] = $debt_amount;
    }

    public function getDebt_reductionRate()
    {
        return  $this->attributes['reductionRate'];
    }

    public function setDebt_reductionRate($reductionRate)
    {
        $this->attributes['reductionRate'] = $reductionRate;
    }

    public function getDebt_meters_id()
    {
        return  $this->attributes['meters_id'];
    }

    public function setgetDebt_meters_id($meters_id)
    {
        $this->attributes['meters_id'] = $meters_id;
    }

    public function getAttributes()
    {
        return  $this->attributes;
    }
    
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
    }
}
