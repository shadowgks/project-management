<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InputFile extends Component
{
    public $_id;
    public $_key;
    public $class;
    public $files;
    public $button = false;
    public $model = null;
    public $onchange = null;

    public function render()
    {
        if ($this->_id == null)
            throw new \Exception("Input file component must have an id! Add attribute ( _id=\"YOUR_INPUT_ID\" ) to component.");

        return view('livewire.input-file');
    }
}
