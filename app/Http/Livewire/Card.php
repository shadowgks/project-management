<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Card extends Component
{
    public $_id;
    public $_key;
    public $class;
    public $content;

    public function render()
    {
        return view('livewire.components.card');
    }
}
