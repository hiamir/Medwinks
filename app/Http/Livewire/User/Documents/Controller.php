<?php

namespace App\Http\Livewire\User\Documents;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='document';
    }
    public function render()
    {
        return view('livewire.user.documents.controller');
    }
}
