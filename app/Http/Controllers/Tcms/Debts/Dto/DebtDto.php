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

    public function getAttributes()
    {
        return  $this->attributes;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }
}
