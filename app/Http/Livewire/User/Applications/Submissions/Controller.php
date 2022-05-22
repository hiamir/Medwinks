<?php

namespace App\Http\Livewire\User\Applications\Submissions;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='applications';
    }
    public function render()
    {
        return view('livewire.user.applications.submissions.controller');
    }
}
