<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CardShow extends Component
{
    public $_id;
    public $_key;
    public $value = null;
    public $title = null;
    public $class = 'bg-primary';
    public $spaceClass = 'p-4';
    public $percentage = null;
    public $withSpace = true;

    public function render()
    {
        return view('livewire.components.card-show');
    }
}
