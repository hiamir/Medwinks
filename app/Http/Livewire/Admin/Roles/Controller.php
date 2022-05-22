<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='role';
    }
    public function render()
    {
        return view('livewire.admin.roles.controller');
    }
}
