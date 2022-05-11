<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class AuthInput extends Component
{
    public $type, $name, $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $name, $placeholder)
    {
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.auth-input');
    }
}
