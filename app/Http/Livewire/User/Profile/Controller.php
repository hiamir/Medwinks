<?php

namespace App\Http\Livewire\User\Profile;

use App\Http\Livewire\Authenticate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Controller extends Authenticate
{
    public function mount(Request $request){
        $this->modalDetails['model']='profile';
    }
    public function render()
    {
        return view('livewire.user.profile.controller');
    }
}
