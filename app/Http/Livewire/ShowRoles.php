<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\RolePermission;

class ShowRoles extends Component
{

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

    public $roles; 

    public function render()
    {
        return view('livewire.roles.show-roles');
    }

    public function mount(){
        
        $this->roles = Role::with('app')->with('gate')->get()->toArray();
    }

    public function new_role()
    {
        
        redirect()->route('role.index', [0]);
        
    }

    public function delete_role($id)
    {
        RolePermission::where('role_id', $id)->delete();
        Role::where('id', $id)->delete();

        $this->roles = Role::with('app')->with('gate')->get()->toArray();

    }

    public function edit_role($id)
    {
        return redirect()->route('role.index', $id);


    }
}
