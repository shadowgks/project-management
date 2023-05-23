<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Str;

class Popover extends Component
{
    public $icon = 'exclamation-circle';
    public $title = '';
    public $content = '';
    public $position = 'bottom';
    public $class;

    public function render()
    {
        return view('livewire.components.popover');
    }

    public function getPosition()
    {
        $position = Str::lower($this->position);

        if (!in_array($position, ['top', 'left', 'bottom', 'right']))
            $position = 'bottom';

        return $position . '-popover';
    }
}
