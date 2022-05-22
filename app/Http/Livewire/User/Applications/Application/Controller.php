<?php

namespace App\Http\Livewire\User\Applications\Application;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='application';
    }
    public function render()
    {
        return view('livewire.user.applications.application.controller');
    }
}
