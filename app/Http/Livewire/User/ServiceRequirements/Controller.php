<?php

namespace App\Http\Livewire\User\ServiceRequirements;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='service-requirement';
    }
    public function render()
    {
        return view('livewire.user.service-requirements.controller');
    }
}
