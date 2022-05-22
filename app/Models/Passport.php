<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;

    public function comments(){
        return $this->morphToMany(Comments::class,'commentable');
    }
    public function applications(){
        return $this->hasMany(Application::class,'passports_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class,'countries_id');
    }

    public function region(){
        return $this->belongsTo(Region::class,'regions_id');
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

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::parse($value)->format('Y-m-d');
    }

//    public function getDateOfBirthAttribute($value)
//    {
//        return  Carbon::parse($this->attributes['date_of_birth'])->format('l, F j, Y');
//    }

    public function setIssueDateAttribute($value)
    {
        $this->attributes['issue_date'] = Carbon::parse($value)->format('Y-m-d');
    }

//    public function getIssueDateAttribute($value)
//    {
//        return  Carbon::parse($this->attributes['issue_date'])->format('F j, Y');
//    }

    public function setExpiryDateAttribute($value)
    {
        $this->attributes['expiry_date'] = Carbon::parse($value)->format('Y-m-d');
    }

//    public function getExpiryDateAttribute($value)
//    {
//        return  Carbon::parse($this->attributes['expiry_date'])->format('F j, Y');
//    }
}
