<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Http\Livewire\Authenticate;
use Illuminate\Http\Request;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='menu';
    }
    public function render()
    {
        return view('livewire.admin.menu.controller');
    }
}
