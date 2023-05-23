<?php

namespace App\Http\Livewire;


use Livewire\WithFileUploads;
use App\Traits\AppTrait;
use App\Helpers\SettingsHelper;
use App\Core\Adapters\Theme;
use App\Core\Data;
use Livewire\Component;
use App\Models\UserInfo;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\AppModule;
use App\Models\UserPermission;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Hash;

class AppUser extends Component
{
    use AppTrait;
    use WithFileUploads;

    protected $listeners = [
        'alertResult',
    ];

    public $avatar;
    public $base_data = [
        'keys' => ['app_logo', 'app_dark_logo', 'app_favicon', 'app_name', 'theme', 'app_language', 'app_timezone'],
        'menuElements' => [
            [
                'name' => 'general_info',
                'component' => 'general_info',
            ],
            [
                'name' => 'social_media',
                'component' => 'social_media',
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
            [
                'name' => 'event_log',
                'component' => 'event_log',
            ],
        ],
    ];

    public $values = [
        'app_logo' => '',
        'app_dark_logo' => '',
        'app_favicon' => '',
        'app_name' => '',
        'theme' => '',
        'app_language' => '',
        'app_timezone' => '',
        'communication' => [],
        'allow_marketing' => false,
    ];

    protected $rules = [
        'user.first_name' => 'required',
        'user.last_name' => 'required',
        'user.email' => 'required|email',
    ];

    public $user_id = 0;
    public $user ;
    public $permissions;
    public $password;

    public $modules_permission ;
    public $email_sent;
    public $email_received;
    public $notif_permissions;
    public $pdf_permissions;
    public $validation_permissions;
    public $avatar_remove;
    public $fileName;

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

    public function render()
    {
        return view('livewire.users.app-user');
    }

    public function mount($id)
    {
        $this->user_id = $id;

        $this->modules_permission = AppModule::with(['permission'=>function($query){
            $query->where('category','module');
        }])->get()->toArray();



        $this->email_sent = AppModule::with(['permission'=>function($query){
            $query->where('category','send_email');
        }])->get()->toArray();


        $this->email_received = AppModule::with(['permission'=>function($query){
            $query->where('category','receive_email');
        }])->get()->toArray();

        $this->notif_permissions = AppModule::with(['permission'=>function($query){
            $query->where('category','notification');
        }])->get()->toArray();

        $this->pdf_permissions = AppModule::with(['permission'=>function($query){
            $query->where('category','pdf');
        }])->get()->toArray();

        $this->validation_permissions = AppModule::with(['permission'=>function($query){
            $query->where('category','validation');
        }])->get()->toArray();


        $UserPermission = UserPermission::where('user_id',$this->user_id)->get();
        foreach($UserPermission as $row){
            $this->permissions[$row->permission_id] = $row->value;
        }

        $user = User::where('id', $this->user_id)->with('info')->get();
        if(count($user) > 0 ){
            $this->user = $user->first()->toArray();
            $this->avatar = $this->user['image_name'];
        }else{
            $this->user = [];
        }

        $this->base_data['roles'] = Role::all()->toArray();
    }

    public function select_tab($key)
    {
        $this->options['selectedTab'] = $key;
    }



    public function submit_permissions()
    {
        foreach($this->permissions as $permission_id => $value){

            $user_permissions = UserPermission::updateOrCreate(
                ['permission_id' => $permission_id , 'user_id' => $this->user_id ],
                ['permission_id' => $permission_id , 'user_id' => $this->user_id ,'value' => $value]
            );
        }

        if($user_permissions->wasChanged() OR $user_permissions->wasRecentlyCreated ){
            $this->showSlideAlert('success', 'Data saved successfully!');

        }else{
            $this->showAlert('error', 'No changes have been applied!');

        }
    }

    public function discard()
    {
        array_walk($this->base_data['keys'], function ($key) {
            $this->values[$key] = $this->base_data['old_values'][$key];
        });
    }


    public function submit_general_info()
    {


        $this->validate();

        $user = User::where('id',$this->user_id)->first()->toArray();
        $fileName = '';
        if(isset($this->avatar) and $this->avatar != $user['image_name']){

            $fileName = $this->avatar->store('users', 'public');
        }
        $this->user['image_name'] = $fileName;

        if($this->password != ''){
            $newPassword = Hash::make($this->password);
        }

        $newUser = User::updateOrCreate(
            ['id' => $this->user_id ],
            [
                'first_name' => $this->user['first_name'],
                'last_name' => $this->user['last_name'],
                'email' => $this->user['email'],
                'is_admin' => $this->user['is_admin'],
                'role_id' => $this->user['role_id'],
             ]
        );

        if(isset($newPassword)){

            $passwordAction = User::where('id', $newUser->id)->update(['password' => $newPassword]);
            $newUser->wasRecentlyCreated = (!$newUser->wasRecentlyCreated)?$passwordAction:$newUser->wasRecentlyCreated;
        }

        if(isset($this->avatar) and $this->avatar != $user['image_name']){

            User::where('id', $newUser->id)->update(['image_name' => $fileName]);
        }

        if(isset($user['role_id']) and $this->user['role_id'] != $user['role_id']){

            $rolePermission = RolePermission::where('role_id',$this->user['role_id'])->get()->toArray();
            foreach($rolePermission as  $key => $value){
                UserPermission::updateOrCreate(
                    ['permission_id' => $value['permission_id'] , 'user_id' => $this->user_id ],
                    ['permission_id' => $value['permission_id'] , 'user_id' => $this->user_id ,'value' => $value['value']]
                );
            }
        }

        $newUserInfo = UserInfo::updateOrCreate(
            ['user_id' => $this->user_id ],
            [
                'phone' => $this->user['info']['phone'],
                'address' => $this->user['info']['address'],
                'user_id' => $newUser->id
            ]
        );
        if($newUserInfo->wasChanged() OR $newUserInfo->wasRecentlyCreated){
            $newUser->wasRecentlyCreated = true;
        }

        if($newUser->id != $this->user_id){
            return redirect()->route('user.index', [$newUser->id]);

        }

        $UserPermission = UserPermission::where('user_id',$this->user_id)->get();
        foreach($UserPermission as $row){
            $this->permissions[$row->permission_id] = $row->value;
        }

        if($newUser->wasChanged() OR $newUser->wasRecentlyCreated ){
            $this->showSlideAlert('success', 'Data saved successfully!');

        }else{
            $this->showAlert('error', 'No changes have been applied!');

        }
    }

    public function submit_social_media()
    {

        $user_info = UserInfo::updateOrCreate(
            ['user_id' => $this->user_id ],
            [
                'website' => $this->user['website'],
                'facebook' => $this->user['facebook'],
                'linkedin' => $this->user['linkedin'],
                'skype' => $this->user['skype'],
            ]
        );

        if($user_info->wasChanged() OR $user_info->wasRecentlyCreated ){
            $this->showSlideAlert('success', 'Data saved successfully!');

        }else{
            $this->showAlert('error', 'No changes have been applied!');

        }
    }

    public function alertResult($result)
    {
        $this->hideAlert();
    }
}
