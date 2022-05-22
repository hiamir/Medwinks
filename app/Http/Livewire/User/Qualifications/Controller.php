<?php

namespace App\Http\Livewire\User\Qualifications;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='qualification';
    }
    public function render()
    {
        return view('livewire.user.qualifications.controller');
    }
}
