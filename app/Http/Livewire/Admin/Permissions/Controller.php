<?php

namespace App\Http\Livewire\Admin\Permissions;

use App\Http\Livewire\Authenticate;
use Livewire\Component;

class Controller extends Authenticate
{
    public function render()
    {
        return view('livewire.admin.permissions.controller');
    }
}
