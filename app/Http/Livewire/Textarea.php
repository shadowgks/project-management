<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Textarea extends Component
{
    public $_id;
    public $_key;
    public $label;
    public $labelClass;
    public $inputClass;
    public $rows = 6;
    public $cols;
    public $name;
    public $class;
    public $model;
    public $change;
    public $required = false;

    public function render()
    {
        return view('livewire.components.textarea');
    }
}
