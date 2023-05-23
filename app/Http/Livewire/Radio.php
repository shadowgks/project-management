<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Radio extends Component
{
    public $_id;
    public $_key;
    public $label = 'Default radio';
    public $labelClass;
    public $inputClass;
    public $name;
    public $class;
    public $src;
    public $_value;
    public $model;
    public $change;
    public $value;
    public $checked = false;

    public function render()
    {
        return view('livewire.components.radio');
    }
}
