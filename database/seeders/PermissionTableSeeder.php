<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'provider-show',
            'customer-list',
            'customer-create',
            'customer-show',
            'customer-assigndebt',
            'tariff-list',
            'tariff-show',
            'tariff-edit',
            'tariff-create',
            'user-list',
            'user-show',
            'user-edit',
            'user-create',
            'provcateg-list',
            'provcateg-show',
            'provcateg-edit',
            'provcateg-create',
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
