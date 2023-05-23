<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ModuleController extends Component
{
    public $data = [
        'values' => [
            'module_name' => '',
            'description' => '',
            'help_name' => '',
        ],
    ];

    public $options = [
        'selected_step' => 1,
    ];

    public function render()
    {
        return view('livewire.module-controller');
    }

    public function action_step($action)
    {
        if ($action == 'next')
            $this->options['selected_step'] += 1;
        else
            $this->options['selected_step'] -= 1;
    }

    public function cancel()
    {
        $this->data['values'] = [
            'module_name' => '',
            'description' => '',
            'help_name' => '',
        ];

        $this->options['selected_step'] = 1;
    }
}
