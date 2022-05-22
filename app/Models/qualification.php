<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qualification extends Model
{
    use HasFactory;

    public function degrees(){
        return $this->hasMany(Degree::class);
    }

    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value); // now date is a carbon instance
        return $date->diffForHumans(Carbon::now());
    }

    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value); // now date is a carbon instance
        return $date->diffForHumans(Carbon::now());
    }
}
