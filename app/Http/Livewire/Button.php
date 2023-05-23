<?php

namespace App\Http\Livewire;

use App\Helpers\ControllerHelper;
use Livewire\Component;

class Button extends Component
{
    public $_id;
    public $_key;
    public $type = "button";
    public $title;
    public $class = 'btn-primary';
    public $click;

    public function render()
    {
        return view('livewire.components.button');
    }

    public function actionClick()
    {
        $clicks = explode('.', $this->click);
        $controller = ControllerHelper::getController($clicks[0], true);
        $variable = $clicks[1];
        $controller->$variable();
    }
}
