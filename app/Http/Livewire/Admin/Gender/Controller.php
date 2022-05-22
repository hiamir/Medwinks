<?php

namespace App\Http\Livewire\Admin\Gender;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{

    public function render()
    {
        return view('livewire.admin.gender.controller');
    }
}
