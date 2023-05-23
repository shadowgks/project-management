<?php

namespace App\Http\Livewire;

use App\Helpers\ControllerHelper;
use Livewire\Component;

class Input extends Component
{
    public $_id;
    public $_key;
    public $type = 'text';
    public $label;
    public $labelClass;
    public $inputClass;
    public $placeholder;
    public $name;
    public $class;
    public $value;
    public $model;
    public $change;
    public $required = false;

    public function render()
    {
        return view('livewire.components.input');
    }

    public function setValue()
    {
        $models = explode('.', $this->model);
        $controller = ControllerHelper::getController($models[0], true);
        $variable = $models[1];
        $controller->$variable = $this->value;
    }
}
