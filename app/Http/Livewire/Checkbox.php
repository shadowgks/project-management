<?php

namespace App\Http\Livewire;

use App\Helpers\ControllerHelper;
use Livewire\Component;

class Checkbox extends Component
{
    public $_id;
    public $_key;
    public $label = 'Default checkbox';
    public $labelClass;
    public $inputClass;
    public $name;
    public $class;
    public $_value;
    public $model;
    public $change;
    public $value;
    public $checked = false;

    public function render()
    {
        return view('livewire.components.checkbox');
    }

    public function setValue()
    {
        $models = explode('.', $this->model);
        $controller = ControllerHelper::getController($models[0], true);
        $variable = $models[1];
        $controller->$variable = $this->_value;
    }
}
