<?php

namespace Database\Seeders;

use App\Models\AppModule;
use App\Models\DropDown;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DropdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppModule::create([
            'name' => 'Demo',
            'pseudo_name' => 'demo',
            'description' => '',
            'empty_when_reinitializating' => 1,
            'emailing' => false,
            'notifications' => false,
            'pdf' => false,
            'contain_validator' => false,
            'activate_importation' => false,
            'activate_file_upload' => false,
            'activate_comments' => false,
            'activate_reminders' => false,
            'activate_duplicate' => false,
            'namespace' => 'Modules/Demo',
            'gate_id' => 1,
            'app_id' => 1,
            'active' => true,
            'user_id' => 1,
        ]);

        $data = $this->data();

        foreach ($data as $value) {
            DropDown::create([
                'select_field' => $value['select_field'],
                'select_id' => $value['select_id'],
                'select_value' => $value['select_value'],
                'app_module_id' => $value['app_module_id'],
                'user_id' => 1,
            ]);
        }
    }

    private function data()
    {
        return [
            // Accounting classes
            [
                'select_field' => 'classification_id',
                'select_id' => '1',
                'select_value' => '1',
                'app_module_id' => '1',
            ],
            [
                'select_field' => 'classification_id',
                'select_id' => '2',
                'select_value' => '2',
                'app_module_id' => '1',
            ],
            [
                'select_field' => 'classification_id',
                'select_id' => '3',
                'select_value' => '3',
                'app_module_id' => '1',
            ],
            [
                'select_field' => 'classification_id',
                'select_id' => '4',
                'select_value' => '4',
                'app_module_id' => '1',
            ],
            [
                'select_field' => 'classification_id',
                'select_id' => '5',
                'select_value' => '5',
                'app_module_id' => '1',
            ],
            [
                'select_field' => 'classification_id',
                'select_id' => '6',
                'select_value' => '6',
                'app_module_id' => '1',
            ],
            [
                'select_field' => 'classification_id',
                'select_id' => '7',
                'select_value' => '7',
                'app_module_id' => '1',
            ],
            [
                'select_field' => 'classification_id',
                'select_id' => '8',
                'select_value' => '8',
                'app_module_id' => '1',
            ],
            //Accounting types
            [
                'select_field' => 'type_id',
                'select_id' => '1',
                'select_value' => 'tiers',
                'app_module_id' => '1',
            ], [
                'select_field' => 'type_id',
                'select_id' => '2',
                'select_value' => 'normal',
                'app_module_id' => '1',
            ],
        ];
    }
}
