<?php

namespace App\Http\Livewire\User\Dashboard;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='dashboard';
    }
    public function render()
    {
        return view('livewire.user.dashboard.controller');
    }
}
