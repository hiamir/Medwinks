<?php

namespace App\Http\Livewire\Admin\MenuItems;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='menu-items';
    }
    public function render()
    {
        return view('livewire.admin.menu-items.controller');
    }
}
