<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'store products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);
    }
}
