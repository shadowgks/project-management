<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Faker\Generator;
// use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        foreach([1,2] as $id){

            Permission::create([
                'pseudo_name'       => 'view_'.$id,
                'category'          => 'module',
                'app_module_id'          => $id,
                'user_id'           => 1,
            ]);
            Permission::create([
                'pseudo_name'       => 'view_own_'.$id,
                'category'          => 'module',
                'app_module_id'          => $id,
                'user_id'           => 1,
            ]);
            Permission::create([
                'pseudo_name'       => 'edit_'.$id,
                'category'          => 'module',
                'app_module_id'          => $id,
                'user_id'           => 1,
            ]);
            Permission::create([
                'pseudo_name'       => 'delete_'.$id,
                'category'          => 'module',
                'app_module_id'          => $id,
                'user_id'           => 1,
            ]);
            Permission::create([
                'pseudo_name'       => 'send_email_'.$id,
                'category'          => 'send_email',
                'app_module_id'          => $id,
                'user_id'           => 1,
            ]);
            Permission::create([
                'pseudo_name'       => 'receive_email_'.$id,
                'category'          => 'receive_email',
                'app_module_id'       => $id,
                'user_id'           => 1,
            ]);
            Permission::create([
                'pseudo_name'       => 'receive_notif_'.$id,
                'category'          => 'notification',
                'app_module_id'     => $id,
                'user_id'           => 1,
            ]);
        }
    }

    // public function data()
    // {
    //     $data = [];
    //     // list of model permission
    //     $model = ['content', 'user', 'role', 'permission'];

    //     foreach ($model as $value) {
    //         foreach ($this->crudActions($value) as $action) {
    //             $data[] = ['name' => $action];
    //         }
    //     }

    //     return $data;
    // }

    // public function crudActions($name)
    // {
    //     $actions = [];
    //     // list of permission actions
    //     $crud = ['create', 'read', 'update', 'delete'];

    //     foreach ($crud as $value) {
    //         $actions[] = $value.' '.$name;
    //     }

    //     return $actions;
    // }
}
