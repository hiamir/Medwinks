<?php

namespace App\View\Components\FeatherIcons;

use Illuminate\View\Component;

class AlertCircle extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feather-icons.alert-circle');
    }
}
