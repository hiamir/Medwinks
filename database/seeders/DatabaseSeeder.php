<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**n
     *
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(TimezoneSeeder::class);
        $this->call(RegionSeeder::class);

        $this->call(GenderSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(MenuItemSeeder::class);


        // \App\Models\User::factory(10)->create();
    }
}
