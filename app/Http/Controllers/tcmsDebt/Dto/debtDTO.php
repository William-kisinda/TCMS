<?php
namespace App\Http\controllers\tcmsDebt\Dto;
use illuminate\Database\Eloquent\Concers\HasAtributes;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

Class DebtDto{
    use HasAttributes;


    public function SetDebtDto($id,$description,$debtAmount){

        $this->attributes=[];

        $this->attributes['id']=$id;

        $this->attributes['debtAmount']=$debtAmount;

        $this->attributes['description']=$description;


        return $this->attributes;


    }

    public function getMeterNumber(){
        return  $this ->attributes['MeterNumber'];
      }

      public function setMeterNumber($MeterNumber){
          $this ->attributes['MeterNumber']=$MeterNumber;
      }

      public function getMeterId(){
        return  $this ->attributes['id'];
      }
      public function setMeterId($id){
          $this ->attributes['id']=$id;
      }
      public function getMeterStatus(){
        return  $this ->attributes['status'];
      }
      public function setMeterStatus($status){
          $this ->attributes['status']=$status;
      }


      public function getDebtremainingDebtAmount(){
        return  $this ->attributes['remainingDebtAmount'];
      }

      public function setDebtremainingDebtAmount($remainingDebtAmount){
          $this ->attributes['remainingDebtAmount']=$remainingDebtAmount;
      }


      public function getAttributes(){
         return  $this ->attributes;
      }
      public function setAttributes($attributes){
           $this ->attributes=$attributes;
       }

}
