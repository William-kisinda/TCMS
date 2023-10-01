<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model

{
    use HasFactory;
    public $timestamps=false;
    public $primarykey='id';
    public $table = 'meters';


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
        $this ->attributes['MeterNumber']=$id;
    }
    public function getMeterStatus(){
      return  $this ->attributes['status'];
    }
    public function setMeterStatus($status){
        $this ->attributes['status']=$status;
    }

    public function getAttributes(){
       return  $this ->attributes;
    }
    public function setAttributes($attributes){
         $this ->attributes=$attributes;
     }


    public function debt()
    {
        return $this->hasOne(Debt::class, );
    }



}

