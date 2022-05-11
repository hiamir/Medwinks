<?php

namespace App\Http\Livewire\Layouts\Page;

use Livewire\Component;

class Main extends Component
{
    public $header;

    public function mount($header){
        $this->header=$header;
    }
    public function render()
    {
        return view('livewire.layouts.page.main');
    }
}
