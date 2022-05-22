<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    public function serviceRequirement(){
        return $this->belongsTo(ServiceRequirement::class);
    }

    public function applications(){
       return  $this->belongsToMany(Application::class,'application_documents');
    }

public function user(){
      return   $this->belongsTo(User::class,'user_id','id');
}

    public function comments(){
        return $this->morphToMany(Comments::class,'commentable');
    }
//    public function getCreatedAtAttribute($value)
//    {
//        $date = Carbon::parse($value); // now date is a carbon instance
//        return $date->diffForHumans(Carbon::now());
//    }
//
//    public function getUpdatedAtAttribute($value)
//    {
//        $date = Carbon::parse($value); // now date is a carbon instance
//        return $date->diffForHumans(Carbon::now());
//    }
}
