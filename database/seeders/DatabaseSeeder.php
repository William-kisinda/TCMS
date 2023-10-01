<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Meter;
use App\Models\Debt;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed data for the 'meter' table
        Meter::factory(100)->create();

        // Seed data for the 'debt' table
        Debt::factory(100)->create();
    }
}
