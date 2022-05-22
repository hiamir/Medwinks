<?php

namespace App\Http\Livewire\User\SubmitApplication;

use App\Http\Livewire\Authenticate;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;


class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='submit-application';
    }
    public function render()
    {
        return view('livewire.user.submit-application.controller');
    }
}
