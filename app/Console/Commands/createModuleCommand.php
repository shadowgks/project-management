<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class createModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // $request['table_name'][1]
        // $request['table_name'][2]

        //REVIEW - Module creation ✓
        //REVIEW - Models creation ✓
        //REVIEW - Controller content x
        //REVIEW - Form request creation ✓
        //REVIEW - Form request content x
        //REVIEW - Migration content x
        //REVIEW - Principal Model content x
        //REVIEW - Relation content x
        //REVIEW - Views creation x
        //REVIEW - Tables creation ✓
        //REVIEW - Forms creation x
        //REVIEW - Views content x
        //REVIEW - Permissions content
        //REVIEW - Emails template
        //REVIEW - Notifications content

        // ANCHOR Create module
        $module_name = 'test';
        Artisan::call('module:make ' . $module_name);

        $module_description = 'test module';
        $module_empty_when_reinatialization = 0;
        $module_contain_validation = 1;
        $module_emailing = 1;
        $module_notifications = 0;
        $module_pdf = 1;
        $module_gate = 'admin';
        // ANCHOR Save module data in database
        Artisan::call('module:save_in_db', ['name' => $module_name, 'description' => $module_description, 'empty_when_reinatialization' => $module_empty_when_reinatialization, 'contain_validation' => $module_contain_validation, 'emailing' => $module_emailing, 'notifications' => $module_notifications, 'pdf' => $module_pdf]);

        // ANCHOR Save module data in json file
        $json_file = '
        {
        module_data =>{
            "module_name"=>
            "module_description"=>
            "module_empty_when_reinatialization"=>
            "module_contain_validation"=>
            "module_emailing"=>
            "module_notifications"=>
            "module_pdf"=>
            "module_gate"=>
        }
        ';

        // @ Create models + migrations
        //SECTION - Completed

        $tables = [];

        foreach ($tables as $table) {
            $table['table_name'] = '';
            $table['table_contain_numbering'] = '';
            $table['table_contain_barcode'] = '';
            $table['table_contain_user_id'] = '';
            $table_fields = $table['table_fields'];
            $model_content = 'protected $fillable = [';

            // ANCHOR Create table migration
            Artisan::call('php artisan module:make-migration create_' . $table['table_name'] . '_table ' . $module_name);

            // ANCHOR Create table model
            Artisan::call('php artisan module:make-model ' . ucfirst($table['table_name']) . ' ' . $module_name);

            // NOTE Create request
            $request_name = ucfirst(strtolower($module_name)) . 'Request';
            Artisan::call('php artisan module:make-request ' . $request_name . ' ' . ucfirst(strtolower($module_name)));

            // ANCHOR Migration + Model content
            $model_content = "";
            $migration_content = '';
            $request_validation_content = 'return [';
            foreach ($table_fields as $field) {
                $field['field_name'] = '';
                $field['field_type'] = '';
                $field['field_length'] = '';
                $field['field_precesion'] = '';
                $field['field_scale'] = '';
                $field['field_enum_values'] = '';
                $field['field_secondary_key'] = '';
                $field['field_secondary_key_table'] = '';
                $field['field_unique'] = '';
                $field['field_default'] = '';
                $field['field_default_value'] = '';
                $field['field_nullable'] = '';
                $field['field_increment'] = '';
                $field['field_numbering'] = '';
                $field['field_barcode'] = '';
                $model_content .= $field['field_name'] . ', \n';

                // NOTE Table id
                $migration_content .= '$table->bigInteger("' . $field['field_name'] . '");';

                $model_content .= 'id, \n';

                // NOTE Table numbering => migration
                if ($field['field_numbering'] == 1) {
                    $migration_content .= '$table->char("reference",100)->unique();';
                    $migration_content .= '$table->integer("code")->unique();';
                }
                // NOTE Table barcode => migration
                if ($field['field_barcode'] == 1) {
                    $migration_content .= '$table->char("barcode",100)->unique();';
                }

                // NOTE Table numbering => model
                if ($field['field_numbering'] == 1) {

                    $model_content .= 'reference, \n';
                    $model_content .= 'code, \n';
                }
                // NOTE Table barcode => model
                if ($field['field_barcode'] == 1) {
                    $model_content .= 'barcode, \n';
                }

                // NOTE Table foreign key migration
                if ($field['field_secondary_key'] == 1) {

                    $migration_content .= '$table->foreignId("' . $field['field_name'] . '")->constrained("' . $field['field_secondary_key_table'] . '")';
                } else {

                    $migration_content .= '$table->' . $field['field_type'];

                    $migration_content .= '("' . $field['field_name'] . '"';
                    if (in_array($field['field_type'], ['float', 'double', 'decimal'])) {
                        $migration_content .= ',' . $field['field_precesion'] . ',' . $field['field_scale'];
                    }
                    if (in_array($field['field_type'], ['dateTimeTz', 'dateTime'])) {
                        $migration_content .= ',' . $field['field_precesion'];
                    }
                    if (in_array($field['field_type'], ['char'])) {
                        $migration_content .= ',' . $field['field_length'];
                    }
                    $migration_content .= ')';

                    if ($field['field_unique'] == 1) {
                        $migration_content .= '->unique()';
                    }
                }
                if ($field['field_nullable'] == 1) {
                    $migration_content .= '->nullable()';
                }
                if ($field['field_default'] == 1) {
                    $migration_content .= '->default(' . $field['field_default'] . ')';
                }

                $migration_content .= ';\n';
                // NOTE Table foreign key requests
                if ($field['field_secondary_key'] != 1) {

                    if ($field['field_unique'] != 1) {
                        $request_validation_content .= '"' . $field['field_name'] . '"=>"unique:' . $table['table_name'] . '|"';
                    }
                }
                if ($field['field_nullable'] != 1) {
                    $request_validation_content .= '"' . $field['field_name'] . '"=>"required|"';
                }
            }

            $model_content .= ' ]';

            // Numbering interface
            $request_validation_content .= ',';

        }
        $request_validation_content .= '];';

        // ANCHOR create controller with actions
        // Artisan::call('module:make-controller ' . ucfirst(strtolower($module_name)) . 'Controller --resource --requests');

        // ANCHOR controller content
        $save_method = '';

        $save_method .= 'public function save(' . $request_name . ' $request){
            $validated = $request->validated(); \n
         if($request["id"] != "" AND ($request["id"] != null){\n
            ' . $module_name . '::where("id",$request["id"])->save($validated);\n
        }\n
        else{\n
            ' . $module_name . '::save($validated);\n
        }\n
        }';

        // $module_controller = base_path('Modules/' . ucfirst($module_name) . '/Http/Controllers/' . ucfirst($module_name) . 'Controller.php');
        // // NOTE Add save function content in controller
        // file_put_contents($module_controller, implode('',
        //     array_map(function ($data) use ($add_method) {
        //         return stristr($data, 'public function store(Request $request)
        //         {
        //             //
        //         }
        //         ') ? $add_method : $data;
        //     }, file($module_controller))
        // ));
        $view_method = "";
        $delete_method = "";

        // Create notifications

        // Create emails

        // @ Add relations

        // Create forms

        // template choice

        // create permission

        // Json file to track data containing : tables - fields - gate - template - permissions - validation system - motifications - emails

        return Command::SUCCESS;
    }
}
