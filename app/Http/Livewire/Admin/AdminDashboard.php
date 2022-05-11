<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AdminDashboard extends Component
{
    public $header="Dashboard";
    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.page');
    }
}
