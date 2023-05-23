<?php

namespace App\Http\Livewire;

use App\Helpers\ControllerHelper;
use Livewire\Component;

class Range extends Component
{
    public $_id;
    public $_key;
    public $label;
    public $labelClass;
    public $inputClass;
    public $name;
    public $class;
    public $value;
    public $model;
    public $change;

    public function render()
    {
        return view('livewire.components.range');
    }

    public function setValue()
    {
        $models = explode('.', $this->model);
        $controller = ControllerHelper::getController($models[0], true);
        $variable = $models[1];
        $controller->$variable = $this->value;
    }
}
