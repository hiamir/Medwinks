<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class RoleExtends extends Role
{
    public function allPermissions()
    {

        return $this->hasAllPermissions();
    }

    public function links(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
      return $this->belongsToMany(MenuLinks::class,'menu_links_role','role_id');
  }
    public function logs(){
        return $this->morphToMany(Logs::class,'loggable');
    }
//  public function links(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
//  {
//      return $this->hasManyThrough(MenuLinks::class,RoleExtends::class,'id','role_id');
//  }
}
