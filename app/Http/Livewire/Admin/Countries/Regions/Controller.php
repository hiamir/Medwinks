<?php

namespace App\Http\Livewire\Admin\Countries\Regions;

use App\Http\Livewire\Authenticate;
use Livewire\Component;

class Controller extends Authenticate
{
    public function render()
    {
        return view('livewire.admin.countries.regions.controller');
    }
}
