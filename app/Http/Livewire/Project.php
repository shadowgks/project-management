<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Project extends Component
{
    public $data = [
        'templates' => [],
        'tables' => [],
        'values' => [
            'project_name' => '',
            'description' => '',
            'saas' => 'no',
            'template' => '',
            'db_name' => '',
            'tables' => [],
        ],
    ];

    public $options = [
        'selected_step' => 1,
    ];

    public function render()
    {
        return view('livewire.projects.index');
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
            'project_name' => '',
            'description' => '',
            'saas' => 'no',
            'template' => '',
            'db_name' => '',
            'tables' => [],
        ];

        $this->options['selected_step'] = 1;
    }
}
