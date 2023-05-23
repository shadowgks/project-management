<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Alert extends Component
{
    public $_id;
    public $_key;
    public $title;
    public $description;
    public $titleClass;
    public $descriptionClass;
    public $class;
    public $change;

    public function render()
    {
        return view('livewire.components.alert');
    }
}
