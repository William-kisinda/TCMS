<?php

namespace Database\Seeders;

use App\Models\ProviderCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProviderCategory::create([
            'name' => "TANESCO",
            'code' => 'UU7786895'
        ]);
    }
}
