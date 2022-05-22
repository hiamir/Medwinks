<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'admin-dashboard-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-administrators-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-users-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-roles-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-permissions-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-menu-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-menu-items-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-countries-view','guard_name'=>'admin']);
        Permission::create(['name' => 'admin-regions-view','guard_name'=>'admin']);
        Permission::create(['name' => 'user-dashboard-view','guard_name'=>'web']);
    }
}
