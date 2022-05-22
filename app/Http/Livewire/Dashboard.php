<?php

namespace App\Http\Livewire;

use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {

        return view('livewire.dashboard');
    }
}
