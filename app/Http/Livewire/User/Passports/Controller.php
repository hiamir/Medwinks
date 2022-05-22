<?php

namespace App\Http\Livewire\User\Passports;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='passport';
    }
    public function render()
    {
        return view('livewire.user.passports.controller');
    }
}
