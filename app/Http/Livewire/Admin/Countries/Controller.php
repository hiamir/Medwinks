<?php

namespace App\Http\Livewire\Admin\Countries;

use App\Http\Livewire\Authenticate;
use App\Models\Region;
use App\Models\Timezone;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='country';
    }
    public function render()
    {
             return view('livewire.admin.countries.controller');
    }
}
