<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CheckboxImage extends Component
{
    public $_id;
    public $_key;
    public $label = 'Default checkbox';
    public $labelClass;
    public $inputClass;
    public $name;
    public $class;
    public $src;
    public $_value;
    public $model;
    public $change;
    public $value;

    public function render()
    {
        return view('livewire.components.checkbox-image');
    }
}
