<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TariffSedeer extends Seeder
{
    /**
     * Run the database seed for tariffs table.
     * @author Julius
     */
    public function run()
    {
        // Define the data to be seeded
        $tariffs = [
            [
                'name' => 'EWURA',
                'code' => 'EW342',
                'percentageAmount' => '4',
            ],
            [
                'full_name' => 'TRA',
                'code' => 'TN21',
                'percentageAmount' => '18',
            ],
            // Add more tariffs data as needed
        ];

        // Insert the data into the tariffs table
        DB::table('tariffs')->insert($tariffs);
    }
}
