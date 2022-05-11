<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Administrators extends Component
{
    public $header="Administrators";
    public function render()
    {
        return view('livewire.admin.administrators');
    }
}
