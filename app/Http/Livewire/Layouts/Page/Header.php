<?php

namespace App\Http\Livewire\Layouts\Page;

use App\Http\Livewire\Authenticate;
use App\Models\Admin;
use App\Models\User;
use App\Traits\Data;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Authenticate
{
    use Data;
    public bool $darkMode = false;
    protected $listeners = ['refreshComponent' => '$refresh','refreshHeaderComponent' => '$refresh'];

    public function render()
    {
        (Data::guard() === 'admin') ? $profile = Admin::with('profilePhoto')->where('id',auth()->user()->id)->first() : $profile = User::with('profilePhoto')->where('id',auth()->user()->id)->first();
        return view('livewire.layouts.page.header',['profile'=>$profile]);
    }
}
