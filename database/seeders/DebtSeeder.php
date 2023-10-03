<?php

namespace Database\Seeders;
use Faker\Factory as Faker;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DebtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 2; $i++) {
            // Generate a random debt amount within the range of 100 to 1,000
            $debtAmount = rand(100, 1000);

            DB::table('debts')->insert([
                'meters_id' => $i, // Assuming meter_id corresponds to the meter you inserted
                'debtAmount' => $debtAmount,
                'reductionRate' => 0.10, // 10% as a decimal
                'description' => 'Sample Debt ' . $i,
            ]);
        }
    }
}
