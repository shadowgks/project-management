<?php

namespace App\Http\Livewire;

use App\Helpers\ControllerHelper;
use Livewire\Component;
// use App\Http\Livewire;

class Select extends Component
{
    public $_id;
    public $_key;
    public $label;
    public $labelClass;
    public $selectClass;
    public $name;
    public $class;
    public $parent;
    public $value;
    public $model;
    public $change;
    public $default = "Select";
    public $data = [];
    public $dataValue = 'id';
    public $dataText = 'text';
    public $placeholder = 'Select';
    public $multiple = false;

    public function render()
    {
        // dd($this->parent);
        // dd(resolve(\App\Http\Livewire\ShowPosts::get_class()), $this->parent);
        // $vars = explode('.', $this->model);
        // $array_helper = ControllerHelper::getController($vars[0], true);
        // dd(get_class($this->parent), get_object_vars($this->parent), $array_helper);
        return view('livewire.components.select');
    }

    public function setValue()
    {
        // $this->emit('change_value_' . $this->model, $this->value);
        $this->emit('change_select_' . $this->model, $this->value);
        // $vars = explode('.', $this->model);
        // // $controller = ControllerHelper::getControllerString($vars[0], true);
        // $controller = ControllerHelper::getController($vars[0], true);
        // // dd(spl_object_id($this), $this->parent);
        // // dd(\App\Http\Livewire\ShowPosts::class);
        // $class_value = $vars[1];
        // $controller::$$class_value = $this->value;
    }
}
