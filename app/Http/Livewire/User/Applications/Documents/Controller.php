<?php

namespace App\Http\Livewire\User\Applications\Documents;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='documents';
    }
    public function render()
    {
        return view('livewire.user.applications.documents.controller');
    }
}
