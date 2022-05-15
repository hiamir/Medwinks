<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;

class Controller extends Component
{
    public $header="Roles";
    public function render()
    {
        return view('livewire.admin.role.controller');
    }
}
