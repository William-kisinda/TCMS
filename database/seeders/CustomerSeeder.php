<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seed for customer table
     * @author Julius
     */
    public function run()
    {
        // Define the data to be seeded
        $customers = [
            [
                'full_name' => 'John Doe',
                'phone' => '123-456-7890',
                'address' => '123 Main St, City',
            ],
            [
                'full_name' => 'Jane Smith',
                'phone' => '987-654-3210',
                'address' => '456 Elm St, Town',
            ],
            // Add more customer data as needed
        ];

        // Insert the data into the customers table
        DB::table('customers')->insert($customers);
    }
}
