<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public $header="Roles";
    public function render()
    {
        $roles=Role::all();
        return view('livewire.admin.roles',['roles'=>$roles]);
    }
}
