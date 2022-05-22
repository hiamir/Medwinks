<?php

namespace App\Http\Livewire\Admin\Administrators;

use App\Http\Livewire\Authenticate;
use App\Traits\Authorize;
use Illuminate\Http\Request;


class Controller extends Authenticate
{
    use Authorize;

    public function mount(Request $request)
    {

        $this->modalDetails['model'] = 'administrator';
    }

    public function render()
    {
        return view('livewire.admin.administrators.controller');
    }
}
