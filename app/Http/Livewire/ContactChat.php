<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ContactChat extends Component
{
    public $base_data = [
        'contacts' => [],
        'contacts_count' => 0,
    ];

    public $options = [
        'pages' => 0,
        'current_page' => 1,
    ];

    public function render()
    {
        return view('livewire.contact-chat');
    }

    public function mount()
    {
        $users_data = User::getUsers(0);
        $this->base_data['contacts'] = $users_data['list'];
        $this->base_data['contacts_count'] = $users_data['count'];
        $this->options['pages'] = ceil($users_data['count'] / 12);
    }

    public function actionPaginate($value)
    {
        if ($value == 'prev') {
            $this->options['current_page'] = $this->options['current_page'] - 1;
        } else if ($value == 'next') {
            $this->options['current_page'] = $this->options['current_page'] + 1;
        } else {
            $this->options['current_page'] = $value;
        }

        $users_data = User::getUsersByPage($this->options['current_page']);
        $this->base_data['contacts'] = $users_data['list'];
    }
}
