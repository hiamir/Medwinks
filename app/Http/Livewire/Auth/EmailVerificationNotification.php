<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class EmailVerificationNotification extends Component
{
    public function render()
    {
        return view('livewire.auth.email-verification-notification');
    }
}
