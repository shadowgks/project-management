<?php

namespace App\Helpers;

use App\Models\AppModule;
use Artisan;
use Auth;
use DB;
use File;

class ModuleHelper
{

    public static function save_backup($data)
    {
        if (!file_exists(base_path('Modules/Backups/' . $data['module_name'] . '.txt'))) {
            File::put(base_path('Modules/Backups/' . $data['module_name'] . '.txt'), serialize([
                'base_data' => $data['base_data'],
                'values' => $data['values'],
                'tables' => $data['tables'],
                'listing' => $data['listing'],
            ]));
        }
    }

    public static function create_module($module_data, $module_name, $module_pseudo_name)
    {
        $app_module['name'] = $module_name;
        $app_module['pseudo_name'] = $module_pseudo_name;
        $app_module['description'] = $module_data['description'] ?? '';
        $app_module['empty_when_reinitializating'] = $module_data['empty_when_reinitializating'];
        $app_module['emailing'] = $module_data['emailing'];
        $app_module['notifications'] = $module_data['notifications'];
        $app_module['pdf'] = $module_data['pdf'];
        $app_module['contain_validator'] = $module_data['contain_validator'];
        $app_module['activate_importation'] = $module_data['contain_importation'] ?? 1;
        $app_module['activate_file_upload'] = $module_data['activate_file_upload'] ?? 1;
        $app_module['activate_comments'] = $module_data['activate_comments'] ?? 1;
        $app_module['activate_reminders'] = $module_data['activate_reminders'] ?? 1;
        $app_module['activate_duplicate'] = $module_data['activate_duplicate'] ?? 1;
        $app_module['namespace'] = 'Modules\\' . $module_name . '\Entities';
        $app_module['gate_id'] = 1;
        $app_module['user_id'] = Auth::id() != null ? Auth::id() : 1;
        $app_module['app_id'] = 1;
        $app_module['active'] = 1;
        AppModule::insert($app_module);
        $inserted_models['app_modules'] = true;

        Artisan::call('module:make ' . $module_name);

        return DB::getPdo()->lastInsertId();
    }

    public static function generate_request_content($requests_fields){
        $request_validation_content = 'return [';

        // NOTE Table foreign key requests
        // if ($field['field_unique'] == true) {
        //     $request_validation_content .= '"' . $field['field_name'] . '"=>"unique:' . $table['table_name'] . '"';
        //     $request_validation_content .= "\n";
        // }
        // if ($field['field_nullable'] != true) {
        //     $request_validation_content .= '"' . $field['field_name'] . '"=>"required|"';
        // }
        $validation_content = '

        public function validateData(){

            $this->validate_data();

            if(true){


            }
        }
        ';
        // $requests_fields['']['simple']['required'] = true;
        // $requests_fields['']['simple']['min'] = true;
        // $requests_fields['']['simple']['max'] = true;
        // $requests_fields['']['simple']['boolean'] = true;
        // $requests_fields['']['simple']['string'] = true;
        // $requests_fields['']['simple']['email'] = true;
        // $requests_fields['']['simple']['file'] = true;
        // $requests_fields['']['simple']['image'] = true;
        // $requests_fields['']['simple']['integer'] = true;
        // $requests_fields['']['simple']['json'] = true;
        // $requests_fields['']['simple']['password'] = true;
        // $requests_fields['']['simple'][''] = true;
        // $requests_fields['']['simple'][''] = true;
        // $requests_fields['']['simple'][''] = true;

        foreach($requests_fields['simple'] as $simple_request_field){
            

        }

    }

}
