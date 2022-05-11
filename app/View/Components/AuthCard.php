<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuthCard extends Component
{
    public $header,$guard;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($header,$guard)
    {
        $this->header=$header;
        $this->guard=$guard;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.auth-card');
    }
}
