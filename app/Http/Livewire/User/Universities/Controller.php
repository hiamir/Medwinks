<?php

namespace App\Http\Livewire\User\Universities;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='university';
    }
    public function render()
    {
        return view('livewire.user.universities.controller');
    }
}
