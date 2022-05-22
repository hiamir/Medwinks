<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->morphToMany(Comments::class, 'commentable');
    }

    public function passports()
    {
        return $this->belongsTo(Passport::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'universities_id', 'id');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degrees_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'application_documents');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id', 'id');
    }

    public function additionalRequirements()
    {
        return $this->belongsToMany(ServiceRequirement::class, 'application_has_additional_requirements');
    }

    public function serviceRequirements()
    {
        return $this->hasManyThrough(ServiceRequirement::class,Service::class);
    }

    public function selectedDocuments()
    {
        return $this->belongsToMany(Document::class, 'application_documents');
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
