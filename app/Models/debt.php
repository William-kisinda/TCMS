<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    public $table = 'debts';
    public $timestamps='false';


     protected $fillable = [
        'description',
        'reductionRate',
        'debtAmount',
     ];

     public function getReductionRateAttribute($value)
     {
         // Convert the stored fraction to a percentage when retrieving
         return $value * 100;
     }

    /**
     * @return mixed
     */
     public function getDebtId(){
         return  $this ->attributes['id'];
       }

    /**
     * @param mixed $id
     */
    public function setDebtId($id){
        $this ->attributes['id']=$id;
    }

    /**
     * @return mixed
     */
    public function getDebtDescription(){
        return  $this ->attributes['description'];
    }

    /**
     * @param mixed $description
     */
    public function setDebtDescription($description){
        $this ->attributes['description']=$description;
    }

    /**
     * @return mixed
     */
    public function getDebtAmount(){
        return  $this ->attributes['amount'];
    }

    /**
     * @param mixed $debtAmount
     */
    public function setDebtAmount($debtAmount){
        $this ->attributes['amount']=$debtAmount;
    }

    /**
     * @return mixed
     */
    public function getDebtReductionRate(){
        return  $this ->attributes['reductionRate'];
    }

    /**
     * @param mixed $reductionRate
     */
    public function setDebtReductionRate($reductionRate){
        $this ->attributes['reductionRate']=$reductionRate;
    }





          public function getAttributes(){
            return  $this ->attributes;
         }
         public function setAttributes($attributes){
              $this ->attributes=$attributes;

    }

    // public function meter()
    // {
    //     return $this->belongsTo(Meter::class);
    // }

}
