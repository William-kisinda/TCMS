<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class debt extends Model
{
    use HasFactory;

    public $table = 'debts';
    public $timestamps=false;


     protected $fillable = [
         'reductionRate',
         'debtAmount',
         'description',

     ];

     public function getReductionRateAttribute($value)
     {
         // Convert the stored fraction to a percentage when retrieving
         return $value * 100;
     }

     public function getDebtId(){
         return  $this ->attributes['id'];
       }

       public function setDebtId($id){
           $this ->attributes['id']=$id;
       }

       public function getDebtAmout(){
         return  $this ->attributes['debtmount'];
       }
       public function setDebtAmount($debtAmount){
           $this ->attributes['debtAmount']=$debtAmount;
       }
       public function getDebtReductionRate(){
         return  $this ->attributes['reductionRate'];
       }
       public function setDebtReductionRate($reductionRate){
           $this ->attributes['reductionRate']=$reductionRate;
       }





          public function getAttributes(){
            return  $this ->attributes;
         }
         public function setAttributes($attributes){
              $this ->attributes=$attributes;

          }
        public function meter()
        {
            return $this->belongsTo(Meter::class, );
        }

}
