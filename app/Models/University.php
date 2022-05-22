<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
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
