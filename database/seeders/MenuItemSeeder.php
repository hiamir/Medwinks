<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuItem::create(['name'=>'Dashboard','svg'=>'home','guard'=>'admin','route'=>'admin.dashboard','menu_id'=>1,'permissions_id'=>1,'sort'=>1]);
        MenuItem::create(['name'=>'Administrators','svg'=>'','guard'=>'admin','route'=>'admin.admins','menu_id'=>2,'permissions_id'=>2,'sort'=>1]);
        MenuItem::create(['name'=>'Users','svg'=>'','guard'=>'admin','route'=>'admin.users','menu_id'=>2,'permissions_id'=>3,'sort'=>2]);
        MenuItem::create(['name'=>'Roles','svg'=>'','guard'=>'admin','route'=>'admin.roles','menu_id'=>2,'permissions_id'=>4,'sort'=>3]);
        MenuItem::create(['name'=>'Permissions','svg'=>'','guard'=>'admin','route'=>'admin.permissions','menu_id'=>2,'permissions_id'=>5,'sort'=>4]);
        MenuItem::create(['name'=>'Menu','svg'=>'','guard'=>'admin','route'=>'admin.menu','menu_id'=>4,'permissions_id'=>6,'sort'=>1]);
        MenuItem::create(['name'=>'Menu Items','svg'=>'home','guard'=>'admin','route'=>'admin.menu-items','menu_id'=>4,'permissions_id'=>7,'sort'=>2]);
        MenuItem::create(['name'=>'Countries','svg'=>'','guard'=>'admin','route'=>'admin.countries','menu_id'=>3,'permissions_id'=>8,'sort'=>1]);
        MenuItem::create(['name'=>'Regions','svg'=>'','guard'=>'admin','route'=>'admin.country-regions','menu_id'=>3,'permissions_id'=>9,'sort'=>2]);
    }
}
