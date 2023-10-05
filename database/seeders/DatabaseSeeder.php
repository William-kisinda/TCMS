<?php
namespace Database\Seeders;


use App\Models\Debt;
use App\Models\Meter;
use Illuminate\Database\Seeder;
use Database\Seeders\PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
    }
}
