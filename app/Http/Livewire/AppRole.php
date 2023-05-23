<?php

namespace App\Http\Livewire;

use App\Traits\AppTrait;
use App\Helpers\SettingsHelper;
use App\Core\Adapters\Theme;
use App\Core\Data;
use Livewire\Component;
use App\Models\Permission;
use App\Models\Gate;
use App\Models\App;
use App\Models\Role;
use App\Models\User;
use App\Models\AppModule;
use App\Models\RolePermission;
use App\Models\UserPermission;

class AppRole extends Component
{
    use AppTrait;

    protected $listeners = [
        'alertResult',
    ];

    protected $rules = [
        'values.gate_id' => 'required',
        'values.app_id' => 'required',
        'values.name' => 'required',
    ];

    public $base_data = [
        'keys' => ['app_logo', 'app_dark_logo', 'app_favicon', 'app_name', 'theme', 'app_language', 'app_timezone'],
        'gates' => [],
        'apps' => [],
        'menuElements' => [
            [
                'name' => 'general_info',
                'component' => 'general_info',
            ],
            [
                'name' => 'perimission',
                'component' => 'perimission',
            ],
            [
                'name' => 'email_sent',
                'component' => 'email_sent',
            ],
            [
                'name' => 'email_received',
                'component' => 'email_received',
            ],
            [
                'name' => 'notifications',
                'component' => 'notifications',
            ],
            [
                'name' => 'pdf_permission',
                'component' => 'pdf_permission',
            ],
            [
                'name' => 'validation_permission',
                'component' => 'validation_permission',
            ],
        ],
        'settings' => null,
    ];

    public $values = [
        'gate_id' => '',
        'app_id' => '',
        'name' => '',
    ];

    public $options = [
        'selectedTab' => 'general_info',
        'alert' => [
            'show' => false,
            'type' => '',
            'target' => '',
            'content' => '',
            'button' => '',
        ],
    ];



    public $role_id;
    public $permissions;

    public $modules_permission;
    public $email_sent;
    public $email_received;
    public $notif_permissions;
    public $pdf_permissions;
    public $validation_permissions;


    public function mount($id)
    {
        $this->role_id = $id;
        $this->modules_permission = AppModule::with(['permission' => function ($query) {
            $query->where('category', 'module');
        }])->get()->toArray();


        $this->email_sent = AppModule::with(['permission' => function ($query) {
            $query->where('category', 'send_email');
        }])->get()->toArray();


        $this->email_received = AppModule::with(['permission' => function ($query) {
            $query->where('category', 'receive_email');
        }])->get()->toArray();

        $this->notif_permissions = AppModule::with(['permission' => function ($query) {
            $query->where('category', 'notification');
        }])->get()->toArray();

        $this->pdf_permissions = AppModule::with(['permission' => function ($query) {
            $query->where('category', 'pdf');
        }])->get()->toArray();

        $this->validation_permissions = AppModule::with(['permission' => function ($query) {
            $query->where('category', 'validation');
        }])->get()->toArray();

        $rolePermission = RolePermission::where('role_id', $this->role_id)->get();
        foreach ($rolePermission as $row) {
            $this->permissions[$row->permission_id] = $row->value;
        }


        $this->base_data['apps'] = App::all();
        $this->base_data['gates'] = Gate::all();
        $role = Role::where('id', $this->role_id)->first();

        $this->values['name'] = $role->name ?? null;
        $this->values['app_id'] = $role->app_id ?? null;
        $this->values['gate_id'] = $role->gate_id ?? null;
    }

    public function select_tab($key)
    {
        $this->options['selectedTab'] = $key;
    }
    public function render()
    {
        return view('livewire.roles.app-role');
    }


    public function submit_permissions()
    {
        foreach ($this->permissions as $permission_id => $value) {

            $permission = RolePermission::updateOrCreate(
                ['permission_id' => $permission_id, 'role_id' => $this->role_id],
                ['permission_id' => $permission_id, 'role_id' => $this->role_id, 'value' => $value]
            );
        }
        if ($permission->wasChanged() or $permission->wasRecentlyCreated) {

            $this->showSlideAlert('success', 'Data saved successfully!');

            $users = User::where('role_id', $this->role_id)->get()->toArray();
            $rolePermission = RolePermission::where('role_id', $this->role_id)->get()->toArray();
            foreach ($users as $row1) {
                foreach ($rolePermission as $row2) {
                    UserPermission::updateOrCreate(
                        ['permission_id' => $row2['permission_id'], 'user_id' => $row1['id']],
                        ['permission_id' => $row2['permission_id'], 'user_id' => $row1['id'], 'value' => $row2['value']]
                    );
                }
            }
        } else {
            $this->showAlert('error', 'No changes have been applied!');
        }
    }


    public function submit_general_info()
    {

        $this->validate();

        $newRole = Role::updateOrCreate(
            ['id' => $this->role_id],
            ['name' => $this->values['name'], 'app_id' => $this->values['app_id'], 'gate_id' => $this->values['gate_id']]
        );
        if ($newRole->id != $this->role_id) {
            return redirect()->route('role.index', [$newRole->id]);
        }

        if ($newRole->wasChanged() or $newRole->wasRecentlyCreated) {
            $this->showSlideAlert('success', 'Data saved successfully!');
        } else {
            $this->showAlert('error', 'No changes have been applied!');
        }
    }

    public function alertResult($result)
    {
        $this->hideAlert();
    }
}
