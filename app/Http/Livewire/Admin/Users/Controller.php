<?php

namespace App\Http\Livewire\Admin\Users;

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
        $this->modalDetails['model']='user';
    }
    public function render()
    {
        return view('livewire.admin.users.controller');
    }
}
