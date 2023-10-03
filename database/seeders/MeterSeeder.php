<?php

namespace Database\Seeders;
use Faker\Factory as Faker;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MeterSeeder extends Seeder
{
    /**
     * Run the database seed for meters table.
     * @author Julius
     */

     public function run()

     {
        // Define the data to be seeded
        $meters = [
            [
                'meterNumber' => '374421378543',
                'status' => 'Active',
                'customers_id' => '1',
            ],
            [
                'meterNumber' => '7564389369432',
                'status' => 'Inactive',
                'customers_id' => '2',
            ],
            // Add more customer data as needed
        ];

        // Insert the data into the meters table
        DB::table('meters')->insert($meters);
    }

 }

