<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dropdown extends Component
{
    public $_id;
    public $_key;
    public $title;
    public $class;
    public $buttonClass;
    public $data = [];

    public function render()
    {
        return view('livewire.components.dropdown');
    }
}
