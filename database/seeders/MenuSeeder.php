<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create(['name' => 'Root','svg'=>'home','sort'=>1]);
        Menu::create(['name' => 'Security','svg'=>'security','sort'=>2]);
        Menu::create(['name' => 'Data','svg'=>'data','sort'=>3]);
        Menu::create(['name' => 'Navigation','svg'=>'navigation','sort'=>4]);
    }
}
