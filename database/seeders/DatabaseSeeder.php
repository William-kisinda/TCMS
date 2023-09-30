<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ProviderCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\ProviderCategory::factory()->create([
        //     'name' => "TANESCO",
        //     'code' => 'UU7786895'
        // ]);

        $this->call(CreateAdminUserSeeder::class);
    }
}
