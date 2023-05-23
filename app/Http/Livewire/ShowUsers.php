<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\RolePermission;

class ShowUsers extends Component
{


    public $users;

    public $base_data = [
        'title' => 'Template Demo 1',
        'data' => [],
        'columns' => [],
        'totals' => [],
        'custom_filters' => [],
        'filterLoopsLength' => 0,
    ];

    public $options = [
        'id' => null,
        'show_modal' => false,
        'show_filters' => false,
        'helper' => '',
        'alert' => [
            'show' => false,
            'type' => '',
            'target' => '',
            'content' => '',
            'button' => '',
        ],
    ];

    public function render()
    {
        return view('livewire.users.show-users');
    }

    public function mount()
    {
        $this->users = User::with('info')->get()->toArray();
        
    }


    public function new_user(){
        
        redirect()->route('user.index', [0]);
    }
    
    public function delete_user($id)
    {
        UserPermission::where('role_id', $id)->delete();
        User::where('id', $id)->delete();

        $this->users = User::with('info')->get()->toArray();

    }

    public function edit_user($id)
    {
        return redirect()->route('user.index', $id);


    }

}
