<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class createTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

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
        $module_name = 'test';
        // $tables = array(
        //     0 => array(
        //         'table_name' => 'first_module',
        //         'table_contain_numbering' => 1,
        //         'table_contain_barcode' => 1,
        //         'table_contain_user_id' => 1,
        //         'table_fields' => array(
        //             0 => array(
        //                 'field_name' => 'name',
        //                 'field_type' => 'char',
        //                 'field_length' => '150',
        //                 'field_precesion' => '',
        //                 'field_scale' => '',
        //                 'field_enum_values' => '',
        //                 'field_secondary_key' => '',
        //                 'field_secondary_key_table' => '',
        //                 'field_unique' => '',
        //                 'field_default' => '',
        //                 'field_default_value' => '',
        //                 'field_nullable' => '',
        //                 'field_increment' => '',
        //             ),
        //             1 => array(
        //                 'table_name' => 'test',
        //                 'table_contain_numbering' => 1,
        //                 'table_contain_barcode' => 1,
        //                 'table_contain_user_id' => 1,
        //                 'table_contain_numbering' => 1,
        //                 'table_fields' => array(
        //                     0 => array(
        //                         'field_name' => 'Jane Doe',
        //                         'field_type' => 'jane@example.com',
        //                         'field_type' => '',
        //                         'field_length' => '',
        //                         'field_precesion' => '',
        //                         'field_scale' => '',
        //                         'field_enum_values' => '',
        //                         'field_secondary_key' => '',
        //                         'field_secondary_key_table' => '',
        //                         'field_unique' => '',
        //                         'field_default' => '',
        //                         'field_default_value' => '',
        //                         'field_nullable' => '',
        //                         'field_increment' => '',
        //                     ),

        //                 ),
        //             ),
        //         )
        //     )
        // );
        array(
            array(
                "table_name" => "orders",
                "table_contain_numbering" => true,
                "table_contain_barcode" => true,
                "fields" => array(
                    array(
                        "field_name" => "order_type",
                        "field_type" => "string",
                        "field_length" => "50",
                        "field_precision" => 0,
                        "field_scale" => 0,
                        "field_enum_values" => 0,
                        "field_seconday_key" => false,
                        "field_seconday_value" => "",
                        "field_unique" => false,
                        "field_default" => true,
                        "field_default_value" => "simple",
                    ),
                    array(
                        "field_name" => "total_ht",
                        "field_type" => "decimal",
                        "field_length" => 0,
                        "field_precision" => "15",
                        "field_scale" => "2",
                        "field_enum_values" => 0,
                        "field_seconday_key" => false,
                        "field_seconday_value" => "",
                        "field_unique" => false,
                        "field_default" => false,
                        "field_default_value" => "",
                    ),
                    array(
                        "field_name" => "discount",
                        "field_type" => "decimal",
                        "field_length" => 0,
                        "field_precision" => "15",
                        "field_scale" => "2",
                        "field_enum_values" => 0,
                        "field_seconday_key" => false,
                        "field_seconday_value" => "",
                        "field_unique" => false,
                        "field_default" => false,
                        "field_default_value" => "",
                    ),
                    array(
                        "field_name" => "tax",
                        "field_type" => "decimal",
                        "field_length" => 0,
                        "field_precision" => "15",
                        "field_scale" => "2",
                        "field_enum_values" => 0,
                        "field_seconday_key" => false,
                        "field_seconday_value" => "",
                        "field_unique" => false,
                        "field_default" => false,
                        "field_default_value" => "",
                    ),
                    array(
                        "field_name" => "total_ttc",
                        "field_type" => "decimal",
                        "field_length" => 0,
                        "field_precision" => "15",
                        "field_scale" => "2",
                        "field_enum_values" => 0,
                        "field_seconday_key" => false,
                        "field_seconday_value" => "",
                        "field_unique" => false,
                        "field_default" => false,
                        "field_default_value" => "",
                    ),
                    array(
                        "field_name" => "comment",
                        "field_type" => "text",
                        "field_length" => "255",
                        "field_precision" => 0,
                        "field_scale" => 0,
                        "field_enum_values" => 0,
                        "field_seconday_key" => false,
                        "field_seconday_value" => "",
                        "field_unique" => false,
                        "field_default" => false,
                        "field_default_value" => "",
                    ),
                    array(
                        "field_name" => "date",
                        "field_type" => "date",
                        "field_length" => 0,
                        "field_precision" => 0,
                        "field_scale" => 0,
                        "field_enum_values" => 0,
                        "field_seconday_key" => false,
                        "field_seconday_value" => "",
                        "field_unique" => false,
                        "field_default" => false,
                        "field_default_value" => "",
                    ),
                    array(
                        "field_name" => "project_id",
                        "field_type" => "bigInteger",
                        "field_length" => 0,
                        "field_precision" => 0,
                        "field_scale" => 0,
                        "field_enum_values" => 0,
                        "field_seconday_key" => true,
                        "field_seconday_value" => "project_settings",
                        "field_unique" => true,
                        "field_default" => false,
                        "field_default_value" => "",
                    ),
                ),
            ),
        );

//         array:5 [▼ // app/Http/Livewire/Module.php:567
//   "module" => array:8 [▼
//     "name" => ""
//     "empty_when_reinitializating" => true
//     "contain_validator" => false
//     "emailing" => false
//     "notifications" => false
//     "pdf" => false
//     "contain_importation" => false
//     "gate" => "1"
//   ]
//   "relations" => array:2 [▼
//     0 => array:3 [▼
//       "first_model" => "custom_filters"
//       "relation_type" => ""
//       "second_model" => "users"
//     ]
//     1 => array:3 [▼
//       "first_model" => "custom_filters"
//       "relation_type" => ""
//       "second_model" => "project_settings"
//     ]
//   ]
//   "template" => array:4 [▼
//     "type" => "global"
//     "value" => ""
//     "cards" => false
//     "fields" => array:4 [▼
//       0 => array:10 [▼
//         "table" => "0"
//         "column" => "date"
//         "label" => "Date"
//         "type" => "date"
//         "value" => array:4 [▼
//           "type" => "data"
//           "table" => ""
//           "column" => ""
//           "custom" => []
//         ]
//         "default" => ""
//         "placeholder" => ""
//         "length" => 0
//         "min" => 0
//         "max" => 0
//       ]
//       1 => array:10 [▼
//         "table" => "0"
//         "column" => "total_ht"
//         "label" => "total_ht"
//         "type" => "number"
//         "value" => array:4 [▼
//           "type" => "data"
//           "table" => ""
//           "column" => ""
//           "custom" => []
//         ]
//         "default" => ""
//         "placeholder" => ""
//         "length" => 0
//         "min" => 0
//         "max" => 0
//       ]
//       2 => array:10 [▼
//         "table" => "0"
//         "column" => "comment"
//         "label" => "comment"
//         "type" => "text"
//         "value" => array:4 [▼
//           "type" => "data"
//           "table" => ""
//           "column" => ""
//           "custom" => []
//         ]
//         "default" => ""
//         "placeholder" => ""
//         "length" => "4"
//         "min" => 0
//         "max" => 0
//       ]
//       3 => array:10 [▼
//         "table" => "0"
//         "column" => "project_id"
//         "label" => "project"
//         "type" => "select"
//         "value" => array:4 [▼
//           "type" => "custom"
//           "table" => ""
//           "column" => ""
//           "custom" => array:2 [▼
//             0 => array:2 [▼
//               "value" => "1"
//               "text" => "free"
//             ]
//             1 => array:2 [▼
//               "value" => "2"
//               "text" => "client"
//             ]
//           ]
//         ]
//         "default" => ""
//         "placeholder" => ""
//         "length" => 0
//         "min" => 0
//         "max" => 0
//       ]
//     ]
//   ]
//   "numbering" => array:11 [▼
//     "choose_column" => false
//     "table" => ""
//     "column" => ""
//     "use" => true
//     "random" => ""
//     "every-day" => false
//     "every-week" => false
//     "every-month" => true
//     "every-year" => false
//     "form" => array:4 [▼
//       "name" => ""
//       "type" => "standard"
//       "text" => ""
//       "value" => ""
//     ]
//     "elements" => array:4 [▼
//       0 => array:4 [▼
//         "name" => "Year"
//         "type" => "standard"
//         "text" => ""
//         "value" => "4"
//       ]
//       1 => array:4 [▼
//         "name" => "-"
//         "type" => "custom"
//         "text" => "-"
//         "value" => ""
//       ]
//       2 => array:4 [▼
//         "name" => "month"
//         "type" => "standard"
//         "text" => ""
//         "value" => "3"
//       ]
//       3 => array:2 [▼
//         "name" => "Number"
//         "type" => "static"
//       ]
//     ]
//   ]
//   "barcode" => array:12 [▼
//     "choose_column" => false
//     "table" => ""
//     "column" => ""
//     "type" => ""
//     "use" => true
//     "random" => true
//     "every-day" => false
//     "every-week" => false
//     "every-month" => false
//     "every-year" => false
//     "form" => array:5 [▼
//       "barcode_type" => "C39"
//       "name" => ""
//       "type" => "standard"
//       "text" => ""
//       "value" => ""
//     ]
//     "elements" => array:1 [▼
//       0 => array:2 [▼
//         "name" => "Barcode"
//         "type" => "static"
//       ]
//     ]
//   ]
// ]


        // foreach ($tables as $table) {
        //     $table['table_name'] = '';
        //     $table['table_contain_numbering'] = '';
        //     $table['table_contain_barcode'] = '';
        //     $table['table_contain_user_id'] = '';
        //     $table_fields = $table['table_fields'];
        //     $model_content = 'protected $fillable = [';

        //     // ANCHOR Create table migration
        //     Artisan::call('php artisan module:make-migration create_' . $table['table_name'] . '_table ' . $module_name);

        //     // ANCHOR Create table model
        //     if ($table['table_name'] != $module_name) {
        //         Artisan::call('php artisan module:make-model ' . ucfirst($table['table_name']) . ' ' . $module_name);
        //     }

        //     // ANCHOR Migration + Model content
        //     $model_content = "";
        //     $migration_content = '';
        //     foreach ($table_fields as $field) {
        //         $field['field_name'] = '';
        //         $field['field_type'] = '';
        //         $field['field_length'] = '';
        //         $field['field_precesion'] = '';
        //         $field['field_scale'] = '';
        //         $field['field_enum_values'] = '';
        //         $field['field_secondary_key'] = '';
        //         $field['field_secondary_key_table'] = '';
        //         $field['field_unique'] = '';
        //         $field['field_default'] = '';
        //         $field['field_default_value'] = '';
        //         $field['field_nullable'] = '';
        //         $field['field_increment'] = '';
        //         $model_content .= $field['field_name'] . ', \n';

        //         // NOTE Table id
        //         $migration_content .= '$table->primary("' . $field['field_name'] . '");';
        //         $model_content .= 'id, \n';

        //         // NOTE Table numbering
        //         if ($table['table_contain_numbering'] == 1) {
        //             $migration_content .= '$table->char("reference",100)->unique();';
        //             $migration_content .= '$table->integer("code")->unique();';
        //             $model_content .= 'reference, \n';
        //             $model_content .= 'code, \n';
        //         }
        //         // NOTE Table barcode
        //         if ($table['table_contain_barcode'] == 1) {
        //             $migration_content .= '$table->char("barcode",100)->unique();';
        //             $model_content .= 'barcode, \n';
        //         }

        //         // NOTE Table foreign key
        //         if ($field['field_secondary_key'] == 1) {

        //             $migration_content .= '$table->foreignId("' . $field['field_name'] . '")->constrained("' . $field['field_secondary_key_table'] . '")';
        //         } else {

        //             $migration_content .= '$table->' . $field['field_type'];

        //             $migration_content .= '("' . $field['field_name'] . '"';
        //             if (in_array($field['field_type'], ['float', 'double', 'decimal'])) {
        //                 $migration_content .= ',' . $field['field_precesion'] . ',' . $field['field_scale'];
        //             }
        //             if (in_array($field['field_type'], ['dateTimeTz', 'dateTime'])) {
        //                 $migration_content .= ',' . $field['field_precesion'];
        //             }
        //             if (in_array($field['field_type'], ['char'])) {
        //                 $migration_content .= ',' . $field['field_length'];
        //             }
        //             $migration_content .= ')';

        //             if ($field['field_unique'] == 1) {
        //                 $migration_content .= '->unique()';
        //             }
        //         }

        //         if ($field['field_nullable'] == 1) {
        //             $migration_content .= '->nullable()';
        //         }

        //         if ($field['field_default'] == 1) {
        //             $migration_content .= '->default(' . $field['field_default'] . ')';
        //         }

        //         $migration_content .= ';\n';
        //     }

        //     $model_content .= ' ]';
        // }

        $add_method = '';
        $module = Module::find($module_name);
        $module_controller = base_path('Modules/' . ucfirst($module_name) . '/Http/Controllers/' . ucfirst($module_name) . 'Controller.php');
        // NOTE Add create function content in controller
        file_put_contents($module_controller, implode('',
            array_map(function ($data) use ($add_method) {
                return stristr($data, 'public function store(Request $request)
                {
                    //
                }
                ') ? $add_method : $data;
            }, file($module_controller))
        ));

        array_push($this->tables[]['fields'], [
            'field_name' => '',
            'field_type' => '',
            'field_length' => 0,
            'field_precision' => 0,
            'field_scale' => 0,
            'field_enum_values' => 0,
            'field_seconday_key' => false,
            'field_seconday_value' => '',
            'field_unique' => false,
            'field_default' => false,
            'field_default_value' => '',
        ]);

        $fields = [];
        foreach($fields as $field){

            
        }

        return Command::SUCCESS;
    }
}
