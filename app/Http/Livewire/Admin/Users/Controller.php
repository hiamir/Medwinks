<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use App\Traits\Data;
use App\Traits\Query;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;


class Controller extends Component
{
    public function render()
    {
        return view('livewire.admin.users.controller');
    }
}
