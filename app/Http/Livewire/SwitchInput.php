<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SwitchInput extends Component
{
    public $_id;
    public $_key;
    public $label = 'Default switch';
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
        return view('livewire.components.switch-input');
    }
}
