<?php

namespace App\View\Components\Datatable;

use Illuminate\View\Component;

class Table extends Component
{
    public $dataRecord;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($dataRecord)
    {
        $this->dataRecord=$dataRecord;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.datatable.table');
    }
}
