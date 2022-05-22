<?php

namespace App\Http\Livewire\User\ClientDetails;

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
   public $user;
    public function mount(Request $request){
        $this->modalDetails['model']='client-details';
        $this->recordID=$this->user;

    }


    public function render()
    {
        return view('livewire.user.client-details.controller',[$this->user]);
    }
}
