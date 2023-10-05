<?php

namespace Database\Seeders;
use Faker\Factory as Faker;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run()

     {
         for ($i = 1; $i <= 100; $i++) {
             // Generate a random meter number within the specified range
             $meterNumber = rand(10000, 99999);

             DB::table('meters')->insert([
                 'meterNumber' => $meterNumber,
                 'status' => ($i % 2 === 0) ? 'Active' : 'Inactive',
                 
             ]);
         }
     }

 }

