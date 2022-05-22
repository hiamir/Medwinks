<?php

namespace Database\Seeders;

use App\Models\Gender;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return Carbon
     */
    private function random_timestamp()
    {
        return Carbon::today()->subDays(rand(0, 365));
    }
    public function run()
    {
        Gender::create([ 'name' => 'Male', 'created_at'=>$this->random_timestamp(),  'updated_at'=>$this->random_timestamp() ]);
        Gender::create([ 'name' => 'Female', 'created_at'=>$this->random_timestamp(),  'updated_at'=>$this->random_timestamp() ]);

    }
}
