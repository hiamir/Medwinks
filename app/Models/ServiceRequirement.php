<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequirement extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->belongsToMany(Service::class, 'service_has_requirements');
    }

    public function additionalDocuments()
    {
        return $this->hasMany(Document::class);
    }

//    public function applications()
//    {
//        return $this->belongsToMany(Application::class)->using('pivot');
//    }
    public function applications(){
        return $this->belongsToMany(Application::class,'application_has_additional_requirements');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
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

    protected $table = 'service_requirements';
}
