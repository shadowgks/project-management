<?php

namespace App\Http\Livewire;

use App\Helpers\BarcodeHelper;
use App\Helpers\FileHelper;
use App\Helpers\ModelHelper;
use App\Helpers\NumberingHelper;
use App\Helpers\StringHelper;
use App\Models\AppModule;
use App\Models\Barcode_assignment;
use App\Models\DropDown;
use App\Models\Form;
use App\Models\Gate;
use App\Models\Menu;
use App\Models\Numbering_assignment;
use App\Models\Numbering_setting;
use App\Models\Permission;
use App\Models\Status;
use App\Models\Validation;
use App\Models\ValidationStep;
use App\Traits\AppTrait;
use App\Traits\Module\ListingTrait;
use App\Traits\Module\NumberingBarcodeTrait;
use Artisan;
use Auth;
use DB;
use File;
use Livewire\Component;
use Str;

class Module extends Component
{
    use AppTrait;
    use NumberingBarcodeTrait;
    use ListingTrait;

    protected $listeners = [
        'alertResult',
    ];

    // NOTE - Variables
    public $base_data = [
        'title' => 'Module',
        'types' => [
            'bigIncrements',
            'bigInteger',
            'boolean',
            'date',
            'datetime',
            'decimal',
            'double',
            'enum',
            'float',
            'integer',
            'ipAddress',
            'json',
            'string',
            'text',
            'tinyText',
            'mediumText',
            'longText',
            'macAddress',
            'smallInteger',
            'time',
            'timestamps',
            'tinyInteger',
        ],
        'gates' => [
            [
                'id' => 1,
                'name' => 'Admin',
            ],
        ],
        'relation_types' => [
            [
                'id' => 'has_one',
                'name' => 'Has One',
            ],
            [
                'id' => 'has_many',
                'name' => 'Has Many',
            ],
            [
                'id' => 'many_to_many',
                'name' => 'Many To Many',
            ],
        ],
        'template_types' => [
            [
                'id' => 'global',
                'name' => 'Global',
            ],
            [
                'id' => 'separated',
                'name' => 'Separated',
            ],
        ],
        'templates' => [
            [
                'id' => 1,
                'name' => 'Template with modal',
            ],
            [
                'id' => 2,
                'name' => 'Template with form menu',
            ],
            [
                'id' => 3,
                'name' => 'Template with invoice form',
            ],
            [
                'id' => 4,
                'name' => 'Template with normal form',
            ],
        ],
        'tables' => [],
        'element_types' => [],
        'barcode_types' => [],
        'form' => [
            'form_types' => [],
            'columns' => [],
            'value' => [
                'columns' => [],
            ],
        ],
        'columns' => [
            'item',
            'budget',
            'progress',
            'status',
        ],
        // 'data' => [
        //     [
        //         'item' => 'Item 1',
        //         'budget' => 500,
        //         'progress' => 20,
        //         'status' => 'In progress',
        //     ],
        //     [
        //         'item' => 'Item 2',
        //         'budget' => 300,
        //         'progress' => 50,
        //         'status' => 'In progress',
        //     ],
        //     [
        //         'item' => 'Item 3',
        //         'budget' => 1000,
        //         'progress' => 100,
        //         'status' => 'Done',
        //     ],
        // ],
        'users' => [],
        'roles' => [],
        'attributes' => [
            [
                'id' => 'by_role',
                'text' => 'By role',
            ],
            [
                'id' => 'by_user',
                'text' => 'By user',
            ],
        ],

        // NOTE - Listing base data
        'columns_show' => [],
        'data' => [],
        'backups' => [],
    ];

    public $values = [
        'module' => [
            'name' => '',
            'description' => '',
            'empty_when_reinitializating' => false,
            'contain_validator' => false,
            'emailing' => false,
            'notifications' => false,
            'pdf' => false,
            'contain_importation' => false,
            'gate' => '',
        ],
        'relations' => [],
        'template' => [
            'type' => '',
            'value' => '',
            'cards' => true,
            'fields' => [],
            'template_content' => [
                'activate_reminders' => false,
                'activate_duplicate' => false,
                'activate_file_upload' => false,
                'emailing' => false,
                'pdf' => false,
                'activate_comments' => false,
            ],
            'target_save_fields' => 'file',
        ],
        'numbering' => [
            'choose_column' => false,
            'table' => '',
            'column' => '',
            'use_numbering' => '',
            'custom_number' => false,
            'number_initiator' => 1,
            'random' => '',
            'every-day' => false,
            'every-week' => false,
            'every-month' => false,
            'every-year' => false,
            'use_today_date' => false,
            'number_length' => 0,
            'date_field' => '',
            'form' => [
                'name' => '',
                'type' => 'standard',
                'text' => '',
                'value' => '',
            ],
            'elements' => [
                [
                    'name' => 'Number',
                    'type' => 'static',
                ],
            ],
        ],
        'barcode' => [
            'choose_column' => false,
            'table' => '',
            'column' => '',
            'type' => '',
            'use_numbering' => '',
            'custom_number' => false,
            'number_initiator' => 1,
            'random' => '',
            'every-day' => false,
            'every-week' => false,
            'every-month' => false,
            'every-year' => false,
            'use_today_date' => false,
            'number_length' => 0,
            'date_field' => '',
            'form' => [
                'barcode_type' => '',
                'name' => '',
                'type' => 'standard',
                'text' => '',
                'value' => '',
            ],
            'elements' => [
                [
                    'name' => 'Barcode',
                    'type' => 'static',
                ],
            ],
        ],
        'validator' => [
            'name' => '',
            'order' => false,
            'validations' => [],
        ],
        'notification' => [
            'created' => false,
            'edited' => false,
            'deleted' => false,
        ],

        // NOTE - Listing values data
        'name_table' => '',
    ];

    public $options = [
        'selected_step' => 1,
        'element_id' => '',
        'show_filters' => false,
        'show_content' => false,
        'show_modal' => false,
        'show_modal_backups' => false,
        'show_form' => false,
        'errors' => [
            'module_name' => [
                'show' => false,
                'message' => '',
            ],
            'template_type' => [
                'show' => false,
                'message' => '',
            ],
            'template_value' => [
                'show' => false,
                'message' => '',
            ],
            'validator_name' => [
                'show' => false,
                'message' => '',
            ],
        ],
        'alert' => [
            'show' => false,
            'type' => '',
            'target' => '',
            'content' => '',
            'button' => '',
        ],

        // NOTE - Listing options data
        'modal_opened' => false,
        'list_en_going' => false,
        'show_steps_modal' => false,
        'selected_listing_step' => 1,
        'selected_backup_file' => '',
        'target' => 'module',
    ];

    public $tables = [];

    public $elementsForm = [];

    public function render()
    {
        return view('livewire.module');
    }

    public function mount()
    {
        $this->getSupportedData();
    }

    private function getSupportedData()
    {
        $this->base_data['tables'] = ModelHelper::getTables();
        $this->base_data['element_types'] = NumberingHelper::getElementTypes();
        $this->base_data['barcode_types'] = BarcodeHelper::getBarcodeTypes();
        $this->base_data['form']['form_types'] = ModelHelper::getFormTypes();
        $this->base_data['backups'] = ModelHelper::getBackupFiles();
        // dd(User::orderBy('last_name')->get(), Role::orderBy('name')->get());
        // $this->base_data['users'] = User::orderBy('last_name')->get()->toArray();
        // $this->base_data['roles'] = Role::orderBy('name')->get()->toArray();

        // NOTE - Setting base data
        $this->getListingSupportData();
    }

    public function updated()
    {
        // $this->dispatchBrowserEvent('elementsChanged');
    }

    // NOTE - Tables
    public function addTable()
    {
        array_push($this->tables, [
            'table_name' => '',
            'table_contain_numbering' => false,
            'table_contain_barcode' => false,
            'fields' => [],
            'errors' => [
                'show' => false,
                'message' => '',
            ],
        ]);
        $this->listing_cancel();
    }

    public function removeTable($tableKey)
    {
        $arrayHelper = [];

        foreach ($this->tables as $key => $table) {
            if ($key != $tableKey) {
                array_push($arrayHelper, $table);
            }
        }

        $this->tables = $arrayHelper;
        $this->listing_cancel();
    }

    // NOTE - Fields
    public function addField($key)
    {
        array_push($this->tables[$key]['fields'], [
            'field_name' => '',
            'field_type' => '',
            'field_length' => 255,
            'field_precision' => 8,
            'field_scale' => 2,
            'field_enum_values' => 0,
            'field_seconday_key' => false,
            'field_seconday_value' => '',
            'field_unique' => false,
            'field_nullable' => false,
            'field_default' => false,
            'field_default_value' => '',
            'errors' => [
                'field_name' => [
                    'show' => false,
                    'message' => '',
                ],
                'field_type' => [
                    'show' => false,
                    'message' => '',
                ],
            ],
        ]);
        $this->listing_cancel();
    }

    public function removeField($tableKey, $fieldKey)
    {
        $arrayHelper = [];

        foreach ($this->tables[$tableKey]['fields'] as $key => $field) {
            if ($key != $fieldKey) {
                array_push($arrayHelper, $field);
            }
        }

        $this->tables[$tableKey]['fields'] = $arrayHelper;
        $this->listing_cancel();
    }

    public function secondaryKeyAction($tableKey, $fieldKey)
    {
        $field = $this->tables[$tableKey]['fields'][$fieldKey];

        if ($field['field_seconday_key']) {
            $this->tables[$tableKey]['fields'][$fieldKey]['field_type'] = 'integer';
        } else {
            $this->tables[$tableKey]['fields'][$fieldKey]['field_type'] = '';
        }
    }

    // NOTE - Relations
    public function addRelation()
    {
        array_push($this->values['relations'], [
            'first_model' => '',
            'relation_type' => '',
            'second_model' => '',
            'errors' => [
                'first_model' => [
                    'show' => false,
                    'message' => '',
                ],
                'relation_type' => [
                    'show' => false,
                    'message' => '',
                ],
                'second_model' => [
                    'show' => false,
                    'message' => '',
                ],
            ],
        ]);
    }

    public function removeRelation($relationKey)
    {
        $arrayHelper = [];

        foreach ($this->values['relations'] as $key => $relation) {
            if ($key != $relationKey) {
                array_push($arrayHelper, $relation);
            }
        }

        $this->values['relations'] = $arrayHelper;
    }

    // NOTE - Form field
    public function addFormField()
    {
        array_push($this->values['template']['fields'], [
            'active' => true,
            'order' => count($this->values['template']['fields']),
            'table' => '',
            'column' => '',
            'label' => '',
            'design_length' => 12,
            'type' => '',
            'value' => [
                'type' => 'data',
                'table' => '',
                'column' => '',
                'custom' => [],
            ],
            'default' => '',
            'placeholder' => '',
            'length' => 255,
            'min' => 0,
            'max' => 0,
            'previous_dates' => true,
            'next_dates' => true,
            'required' => false,
            'unique' => false,
            'use_regex' => false,
            'regex_value' => '',
            'options' => [
                'show_required' => true,
                'show_unique' => true,
                'popover' => [
                    'use' => false,
                    'content' => '',
                ],
            ],
            'errors' => [
                'table' => [
                    'show' => false,
                    'message' => '',
                ],
                'column' => [
                    'show' => false,
                    'message' => '',
                ],
                'label' => [
                    'show' => false,
                    'message' => '',
                ],
                'type' => [
                    'show' => false,
                    'message' => '',
                ],
            ],
        ]);

        // array_push($this->rules, 'values.template');

        array_push($this->base_data['form']['columns'], []);
        array_push($this->base_data['form']['value']['columns'], []);
    }

    public function removeFormField($formFieldKey)
    {
        $arrayHelper = [];
        $arrayHelper_2 = [
            'columns' => [],
            'value' => [
                'columns' => [],
            ],
        ];

        foreach ($this->values['template']['fields'] as $key => $relation) {
            if ($key != $formFieldKey) {
                array_push($arrayHelper, $relation);
                array_push($arrayHelper_2['columns'], $this->base_data['form']['columns'][$key]);
                array_push($arrayHelper_2['value']['columns'], $this->base_data['form']['value']['columns'][$key]);
            }
        }

        $this->values['template']['fields'] = $arrayHelper;
        $this->base_data['form']['columns'] = $arrayHelper_2['columns'];
        $this->base_data['form']['value']['columns'] = $arrayHelper_2['value']['columns'];
    }

    public function checkFieldOrder($formFieldKey)
    {
        $field = $this->values['template']['fields'][$formFieldKey];

        foreach ($this->values['template']['fields'] as $key => $element) {
            if ($key != $formFieldKey && (isset($element['order']) && $element['order'] == $field['order'])) {
                $this->values['template']['fields'][$key]['order'] = '';
                break;
            }
        }
    }

    public function getColumnsForField($formFieldKey)
    {
        $field = $this->values['template']['fields'][$formFieldKey];
        $table = $this->tables[$field['table']];
        $columns = ModelHelper::getColumnsOfNewTable($table);
        $exist = (count($this->base_data['form']['columns']) - 1 >= $formFieldKey);

        if ($exist) {
            $this->base_data['form']['columns'][$formFieldKey] = $columns;
        } else {
            dd('Columns not found!');
        }
    }

    public function getColumnsForValue($formFieldKey)
    {
        $field = $this->values['template']['fields'][$formFieldKey];
        $table = $field['value']['table'];
        $columns = ModelHelper::getColumnsOfTable($table);
        $exist = (count($this->base_data['form']['value']['columns']) - 1 >= $formFieldKey);

        if ($exist) {
            $this->base_data['form']['value']['columns'][$formFieldKey] = $columns;
        } else {
            dd('Columns not found!');
        }
    }

    public function getColumnOptions($formFieldKey)
    {
        $formField = $this->values['template']['fields'][$formFieldKey];
        $table = $this->tables[$formField['table']];
        $column = null;

        foreach ($table['fields'] as $field) {
            if ($field['field_name'] == $formField['column']) {
                $column = $field;
            }
        };

        $title_name = StringHelper::getTitle($column['field_name']);
        $this->values['template']['fields'][$formFieldKey]['label'] = $title_name;
        if (ModelHelper::isStringType($column['field_type'])) {
            $this->values['template']['fields'][$formFieldKey]['placeholder'] = $title_name;
        }

        if (ModelHelper::isStringType($column['field_type'])) {
            $this->values['template']['fields'][$formFieldKey]['length'] = (int) $column['field_length'];
        } else {
            $this->values['template']['fields'][$formFieldKey]['length'] = 0;
        }

        if (!$column['field_nullable']) {
            $this->values['template']['fields'][$formFieldKey]['required'] = true;
            $this->values['template']['fields'][$formFieldKey]['options']['show_required'] = false;
        } else {
            $this->values['template']['fields'][$formFieldKey]['required'] = false;
            $this->values['template']['fields'][$formFieldKey]['options']['show_required'] = true;
        }

        if ($column['field_unique']) {
            $this->values['template']['fields'][$formFieldKey]['unique'] = true;
            $this->values['template']['fields'][$formFieldKey]['options']['show_unique'] = false;
        } else {
            $this->values['template']['fields'][$formFieldKey]['unique'] = false;
            $this->values['template']['fields'][$formFieldKey]['options']['show_unique'] = true;
        }

        if ($column['field_default']) {
            $this->values['template']['fields'][$formFieldKey]['default'] = $column['field_default_value'];
        } else {
            $this->values['template']['fields'][$formFieldKey]['default'] = '';
        }
    }

    public function addFormFieldCustomValue($formFieldKey)
    {
        array_push($this->values['template']['fields'][$formFieldKey]['value']['custom'], [
            'value' => '',
            'text' => '',
            'errors' => [
                'show' => false,
                'message' => '',
            ],
        ]);
    }

    public function removeFormFieldCustomValue($customFormFieldKey, $formFieldKey)
    {
        $arrayHelper = [];

        foreach ($this->values['template']['fields'][$formFieldKey]['value']['custom'] as $key => $customField) {
            if ($key != $customFormFieldKey) {
                array_push($arrayHelper, $customField);
            }
        }

        $this->values['template']['fields'][$formFieldKey]['value']['custom'] = $arrayHelper;
    }

    // NOTE - Numbering & barcode
    public function addElement($variable, $withData = true)
    {
        if ($withData) {
            $data = $this->values[$variable]['form'];

            array_push($this->values[$variable]['elements'], [
                'name' => ($data['name'] ?? ''),
                'type' => ($data['type'] ?? ''),
                'text' => ($data['text'] ?? ''),
                'value' => ($data['value'] ?? ''),
            ]);

            $this->clearElementForm($variable);
        } else {
            array_push($this->values[$variable]['elements'], [
                'name' => '',
                'type' => '',
                'text' => '',
                'value' => '',
            ]);
        }

        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function editElement($variable, $elementKey)
    {
        $this->options['element_id'] = $elementKey;

        foreach ($this->values[$variable]['elements'][$elementKey] as $key => $value) {
            $this->values[$variable]['form'][$key] = $value;
        }

        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function saveElement($variable)
    {
        $elementKey = $this->options['element_id'];

        foreach ($this->values[$variable]['form'] as $key => $value) {
            $this->values[$variable]['elements'][$elementKey][$key] = $value;
        }

        $this->clearElementForm($variable);
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function removeElement($variable, $elementKey)
    {
        $arrayHelper = [];

        foreach ($this->values[$variable]['elements'] as $key => $relation) {
            if ($key != $elementKey) {
                array_push($arrayHelper, $relation);
            }
        }

        $this->values[$variable]['elements'] = $arrayHelper;
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function changeOrderOfElement($request)
    {
        $arrayHelper = [];

        foreach ($request['elements'] as $key) {
            array_push($arrayHelper, $this->values[$request['variable']]['elements'][$key]);
        }

        $this->values[$request['variable']]['elements'] = $arrayHelper;
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function clearElementForm($variable)
    {
        foreach ($this->values[$variable]['form'] as $key => $value) {
            if (!in_array($key, ['type'])) {
                $this->values[$variable]['form'][$key] = '';
            }
        }

        $this->values[$variable]['form']['type'] = 'standard';
        $this->options['element_id'] = '';
    }

    public function showData()
    {
        dd($this->tables);
    }

    // NOTE - Validation
    public function appedValidation()
    {
        array_push($this->values['validator']['validations'], [
            'name' => '',
            'order' => '',
            'status_name' => '',
            'status_color' => '',
            'errors' => [
                'name' => [
                    'show' => false,
                    'message' => '',
                ],
                'order' => [
                    'show' => false,
                    'message' => '',
                ],
                'status_name' => [
                    'show' => false,
                    'message' => '',
                ],
                'status_color' => [
                    'show' => false,
                    'message' => '',
                ],
            ],
        ]);
    }

    public function removeValidation($validationKey)
    {
        $array_helper = [];

        foreach ($this->values['validator']['validations'] as $key => $operation) {
            if ($key != $validationKey) {
                array_push($array_helper, $operation);
            }
        }

        $this->values['validator']['validations'] = $array_helper;
    }

    public function checkValidationOrder($validationKey)
    {
        $order = $this->values['validator']['validations'][$validationKey]['order'];

        foreach ($this->values['validator']['validations'] as $key => $validation) {
            if ($key != $validationKey && $validation['order'] == $order) {
                $this->values['validator']['validations'][$key]['order'] = '';
                break;
            }
        }
    }

    // NOTE - Steps
    public function action_step($action)
    {
        // dd($this->tables, $this->values, $this->listing);
        // dd($this->listing['values']['settings']);
        $countTables = count($this->tables);

        if ($action == 'next') {
            if (!$this->checkData($this->options['selected_step'])) {
                return;
            }

            if (($countTables == 0 || $countTables > 0 && !$this->tables[0]['table_contain_numbering']) && $this->options['selected_step'] == 4) {
                $this->options['selected_step'] += 1;
            }

            if ($this->options['selected_step'] == 5) {
                if ($countTables == 0 || $countTables > 0 && !$this->tables[0]['table_contain_barcode']) {
                    $this->options['selected_step'] += 1;
                } else {
                    $this->setNumberinToBarcode();
                }
            }

            if (!$this->values['module']['notifications'] && $this->options['selected_step'] == 6) {
                $this->options['selected_step'] += 1;
            }

            if (!$this->values['module']['emailing'] && $this->options['selected_step'] == 7) {
                $this->options['selected_step'] += 1;
            }

            if (!$this->values['module']['pdf'] && $this->options['selected_step'] == 8) {
                $this->options['selected_step'] += 1;
            }

            if (!$this->values['module']['contain_validator'] && $this->options['selected_step'] == 9) {
                $this->options['selected_step'] += 1;
            }

            $this->options['selected_step'] += 1;
        } else {
            if (!$this->values['module']['contain_validator'] && $this->options['selected_step'] == 11) {
                $this->options['selected_step'] -= 1;
            }

            if (!$this->values['module']['pdf'] && $this->options['selected_step'] == 10) {
                $this->options['selected_step'] -= 1;
            }

            if (!$this->values['module']['emailing'] && $this->options['selected_step'] == 9) {
                $this->options['selected_step'] -= 1;
            }

            if (!$this->values['module']['notifications'] && $this->options['selected_step'] == 8) {
                $this->options['selected_step'] -= 1;
            }

            if (($countTables == 0 || $countTables > 0 && !$this->tables[0]['table_contain_barcode']) && $this->options['selected_step'] == 7) {
                $this->options['selected_step'] -= 1;
            }

            if (($countTables == 0 || $countTables > 0 && !$this->tables[0]['table_contain_numbering']) && $this->options['selected_step'] == 6) {
                $this->options['selected_step'] -= 1;
            }

            $this->options['selected_step'] -= 1;
        }
    }

    public function getFileName($basePath, $fileEnd)
    {
        $files = scandir($basePath);
        foreach ($files as $file) {
            if (str_ends_with($file, $fileEnd)) {
                return $file;
            }
        }
    }

    // NOTE - Save module
    public function saveModule()
    {
        // dd($this->values['template'], $this->getTableByKey(0));
        // $listing_content = $this->listing_generate_file(Auth::id(), 8)['controller'];
        // dd($this->listing, $listing_content);
        // dd(ModelHelper::getRelations($this->tables), $this->listing_generate_file(Auth::id(), 15, ModelHelper::getRelations($this->tables)));
        // return;

        try {
            // DB::beginTransaction();
            // FIXME - Module with form (create - edit - delete) + table
            // FIXME - Module of invoices
            // FIXME - Base Project

            // $module_name = ucfirst(strtolower($this->values['module']['name']));
            $module_name = ModelHelper::getModuleName($this->values['module']['name']);
            $module_pseudo_name = str_replace(array('[', ']', ' ', '"', '"'), '', strtolower($module_name));

            //NOTE - FIle put
            // if (!file_exists(base_path('Modules/Backups/' . $module_name . '.txt'))) {
            File::put(base_path('Modules/Backups/' . $module_name . '.txt'), serialize([
                'base_data' => $this->base_data,
                'values' => $this->values,
                'tables' => $this->tables,
                'listing' => $this->listing,
            ]));
            // }

            //NOTE - FIle get
            // $text = File::get(base_path('Modules/Backups/Clients.txt'));
            // $backup = @unserialize($text) ? unserialize($text) : [];

            // if (count($backup) > 0) {
            //     $this->base_data = $backup['base_data'];
            //     $this->values = $backup['values'];
            //     $this->tables = $backup['tables'];
            //     $this->listing = $backup['listing'];
            // } else {
            //     dd('Array is empty!');
            // }
            // return;

            // dd('yooo');
            // dd($this->values, $listing_content, $this->tables);
            // ANCHOR Request Data
            $module_data = $this->values['module'];
            $relation_data = $this->values['relations'];
            $template_data = $this->values['template'];
            $numbering_data = $this->values['numbering'];
            $validation_data = $this->values['validator'];
            $barcode_data = $this->values['barcode'];
            $tables_data = $this->tables;
            // dd($this->tables, $this->values);
            // dd($template_data['fields']);

            $seeder_content = '';
            $seeder_name_spaces_content = '';
            $seeder_name_spaces_content .= '
            use Illuminate\Database\Seeder;
            use App\Models\AppModule;
            use Illuminate\Support\Facades\Artisan;
            use Illuminate\Support\Facades\DB;
            ';
            // ANCHOR Relations content

            // ANCHOR create class file containing all fields
            // ANCHOR insert fields in database
            // ANCHOR Add class name on helper file

            // Add content in controller
            // Save data in database

            // FIXME Edit / Delete

            //TODO - 1 ==> Normal use ==> Stock in database
            //TODO - 1 ==> Complicated use ==> Stock in file

            // ANCHOR Save module data in database ✓

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
            $module_id = DB::getPdo()->lastInsertId();

            $seeder_content .= '
            AppModule::create([
                "name" => "' . $module_name . '",
            "pseudo_name" => "' . $module_pseudo_name . '",
            "description" => "' . ($module_data["description"] ?? '') . '",
            "empty_when_reinitializating" => ' . ($module_data["empty_when_reinitializating"] ? 1 : 0) . ',
            "emailing" => ' . ($module_data["emailing"] ? 1 : 0) . ',
            "notifications" => ' . ($module_data['notifications'] ? 1 : 0) . ',
            "pdf" => ' . ($module_data['pdf'] ? 1 : 0) . ',
            "contain_validator" => ' . ($module_data["contain_validator"] ? 1 : 0) . ',
            "activate_importation" => ' . ($module_data["contain_importation"] ? 1 : 0) . ',
            "activate_file_upload" => ' . ($module_data["activate_file_upload"] ?? 1) . ',
            "activate_comments" => ' . ($module_data["activate_comments"] ?? 1) . ',
            "activate_reminders" => ' . ($module_data["activate_reminders"] ?? 1) . ',
            "activate_duplicate" => ' . ($module_data["activate_duplicate"] ?? 1) . ',
            "namespace" => "' . "Modules\\" . $module_name . "\Entities" . '",
            "gate_id" => 1,
            "user_id" => ' . (Auth::id() != null ? Auth::id() : 1) . ',
            "app_id" => 1,
            "active" => 1,
            ]);
            $app_module_id = AppModule::where("pseudo_name","' . $module_pseudo_name . '")->first()->id;
            ';
            // $listing_content = $this->listing_generate_file(Auth::id(), $module_id);

            $mail_all_tags_content = '';

            // ANCHOR Create module ✓

            Artisan::call('module:make ' . $module_name);
            $seeder_path = 'Modules/' . $module_name . '/Database/Seeders/' . $module_name . 'DatabaseSeeder.php';

            // Anchor Create models + migrations
            // SECTION - Completed

            foreach ($tables_data as $table) {

                $table_fields = $table['fields'];

                // ANCHOR Create table migration ✓
                $migration_file_name = 'create_' . $table['table_name'] . '_table';
                $model_file_name = ModelHelper::getModelName($table['table_name']);
                Artisan::call('module:make-migration ' . $migration_file_name . ' ' . $module_name);

                // ANCHOR Create table model ✓
                $model_name = substr($module_name, 0, -1);
                Artisan::call('module:make-model ' . $model_file_name . ' ' . $module_name);

                // NOTE Create request ✓
                $request_name = $module_name . 'Request';
                Artisan::call('module:make-request ' . $request_name . ' ' . $module_name);

                $model_content = '<?php
            namespace Modules\\' . $module_name . '\Entities;

            use Illuminate\Database\Eloquent\Model;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use App\Models\Reminder;
            use App\Models\File;
            use App\Models\Comment;
            use App\Models\User;

            ';

                if ($table['table_contain_numbering'] == true) {
                    $model_content .= 'use App\Models\Numbering_assignment;';
                    $model_content .= "\n";
                }
                if ($table['table_contain_barcode'] == true) {
                    $model_content .= 'use App\Models\Barcode_assignment;';
                    $model_content .= "\n";
                }
                if ($module_data['contain_validator'] == true) {
                    $model_content .= 'use App\Models\Status;';
                    $model_content .= "\n";
                }
                $model_content .= 'class ' . $model_name . ' extends Model
            {
                use HasFactory;

            ';
                $model_content .= "\n";

                $model_content .= 'protected $table = "' . $table['table_name'] . '";';
                $model_content .= "\n";
                // ANCHOR Numbering system

                if ($table['table_contain_numbering'] == true || $table['table_contain_barcode'] == true) {
                    $numbering_settings['app_module_id'] = $module_id;
                    $numbering_settings['use_numbering'] = $table['table_contain_numbering'];
                    $numbering_settings['use_barcode'] = $table['table_contain_barcode'];
                    $numbering_settings['user_id'] = Auth::id();
                    Numbering_setting::insert($numbering_settings);
                    $numbering_setting_id = DB::getPdo()->lastInsertId();
                }

                if ($table['table_contain_numbering'] == true) {
                    $i = 1;
                    $elements = [];
                    foreach ($numbering_data['elements'] as $element) {

                        if ($element['name'] == 'Number') {
                            $element_value['type'] = 'number';
                            $element_value['value'] = $numbering_data['number_initiator'] ?? 1;
                        } elseif ($element['type'] == 'custom') {
                            $element_value['type'] = 'static';
                            $element_value['value'] = $element['text'];
                        } elseif ($element['type'] == 'standard') {
                            $element_value['type'] = 'date';
                            $element_value['value'] = $element['value'];
                        }
                        $element_value['order'] = $i;

                        array_push($elements, $element_value);
                        $i++;
                    }

                    $numbering_per_periode = [];
                    $periode['year'] = $numbering_data['every-year'];
                    $periode['month'] = $numbering_data['every-month'];
                    $periode['week'] = $numbering_data['every-week'];
                    $periode['day'] = $numbering_data['every-day'];
                    array_push($numbering_per_periode, $periode);

                    $numbering_assignment['random'] = $numbering_data['random'] == "" ? false : $numbering_data['random'];
                    $numbering_assignment['use_today_date'] = $numbering_data['use_today_date'];
                    $numbering_assignment['date_field'] = $numbering_data['date_field'];
                    $numbering_assignment['number_length'] = $numbering_data['number_length'];

                    $numbering_assignment['elements'] = json_encode($elements);
                    $numbering_assignment['numbering_per_periode'] = json_encode($numbering_per_periode);
                    $numbering_assignment['numbering_setting_id'] = $numbering_setting_id;
                    $numbering_assignment['user_id'] = Auth::id();

                    Numbering_assignment::insert($numbering_assignment);
                    $_values_numbering = $this->values['numbering'];
                    $_values_numbering['module_id'] = $module_id;
                    $this->saveNumberingData($this->values['module']['name'] . ' - numbering', $_values_numbering);
                }

                if ($table['table_contain_barcode'] == true) {
                    $i = 1;
                    $elements = [];
                    foreach ($barcode_data['elements'] as $element) {

                        if ($element['name'] == 'Number') {
                            $element_value['type'] = 'number';
                            $element_value['value'] = $numbering_data['number_initiator'] ?? 1;
                        } elseif ($element['type'] == 'custom') {
                            $element_value['type'] = 'static';
                            $element_value['value'] = $element['text'];
                        } elseif ($element['type'] == 'standard') {
                            $element_value['type'] = 'date';
                            $element_value['value'] = $element['text'];
                        }
                        $element_value['order'] = $i;

                        array_push($elements, $element_value);
                        $i++;
                    }
                    $barcode_per_periode = [];
                    // dd($barcode_data);
                    $periode['year'] = $barcode_data['every-year'];
                    $periode['month'] = $barcode_data['every-month'];
                    $periode['week'] = $barcode_data['every-week'];
                    $periode['day'] = $barcode_data['every-day'];
                    array_push($barcode_per_periode, $periode);
                    $barcode_assignment['random'] = $barcode_data['random'] == "" ? false : $barcode_data['random'];
                    $barcode_assignment['barcode_type'] = $barcode_data['form']['barcode_type'] == '' ? 'C128' : $barcode_data['form']['barcode_type'];
                    $barcode_assignment['use_today_date'] = $barcode_data['use_today_date'];
                    $barcode_assignment['date_field'] = $barcode_data['date_field'];
                    $barcode_assignment['number_length'] = $barcode_data['number_length'];
                    $barcode_assignment['elements'] = json_encode($elements);
                    $barcode_assignment['numbering_per_periode'] = json_encode($barcode_per_periode);
                    $barcode_assignment['numbering_setting_id'] = $numbering_setting_id;
                    $barcode_assignment['user_id'] = Auth::id();

                    Barcode_assignment::insert($barcode_assignment);
                    $_values_barcode = $this->values['barcode'];
                    $_values_barcode['module_id'] = $module_id;
                    $this->saveBarcodeData($this->values['module']['name'] . ' - barcode', $_values_barcode);
                }

                // ANCHOR Migration + Model content
                $model_content .= 'protected $fillable = [';
                $migration_content = '';
                // NOTE Table id
                $migration_content .= '$table->bigIncrements("id");';
                $migration_content .= "\n";
                $model_content .= '"id",';
                $model_content .= "\n";
                // NOTE Table numbering => migration
                if ($table['table_contain_numbering'] == true) {
                    $migration_content .= '$table->char("reference",100);';
                    $migration_content .= "\n";
                }
                // NOTE Table barcode => migration
                if ($table['table_contain_barcode'] == true) {
                    $migration_content .= '$table->text("barcode",100)->unique();';
                    $migration_content .= "\n";
                }
                // NOTE Table numbering => model
                if ($table['table_contain_numbering'] == true) {
                    $model_content .= '"reference",';
                    $model_content .= "\n";
                }
                // NOTE Table barcode => model
                if ($table['table_contain_barcode'] == true) {
                    $model_content .= '"barcode",';
                    $model_content .= "\n";
                }
                if ($module_data['emailing'] == true) {
                    $mail_all_tags_content .= '"name" => "id"
                "key" => "id"
                "group" => "' . $module_name . '"

                ';

                    $mail_all_tags_content .= '"name" => "reference",
                "key" => "id",
                "group" => "' . $module_name . '",

                ';
                    if ($table['table_contain_numbering'] == true) {
                        $mail_all_tags_content .= '"value" => "[
                        "type" => "simple",
                        "field_name"=> "reference",
                        "table"=> "' . $table['table_name'] . '",
                    ]"';
                        $mail_all_tags_content .= "\n";
                    }
                    if ($table['table_contain_barcode'] == true) {
                        $mail_all_tags_content .= '"name" => "barcode",
                        "key" => "barcode",
                        "group" => "' . $module_name . '",

                        ';

                        $mail_all_tags_content .= '"value" => "[
                        "type" => "simple",
                        "field_name"=> "barcode",
                        "table"=> "' . $table['table_name'] . '",
                        ]"';
                        $mail_all_tags_content .= "\n";
                    }
                }
                $request_validation_content = 'return [';
                foreach ($table_fields as $field) {

                    $model_content .= '"' . $field['field_name'] . '", ';
                    $model_content .= "\n";

                    $mail_all_tags_content .= '
                ["name" => "' . $field['field_name'] . ',"
                ';
                    $mail_all_tags_content .= '"key" => "' . $field['field_name'] . ',"
                ';
                    $mail_all_tags_content .= '"group" => "' . $module_name . ',"
                ';

                    // NOTE Table foreign key migration
                    if ($field['field_seconday_key'] == true) {

                        $migration_content .= '$table->foreignId("' . $field['field_name'] . '")->constrained("' . $field['field_seconday_value'] . '")';
                        $migration_content .= "\n";
                        $mail_all_tags_content .= '"value" => "[
                        "type" => "simple",
                        "field_name"=> "' . $field["field_name"] . '",
                        "table"=> "' . $field["field_seconday_value"] . '",
                    ]"';

                        $mail_all_tags_content .= "\n";
                    } else {
                        $migration_content .= '$table->' . $field['field_type'];

                        $migration_content .= '("' . $field['field_name'] . '"';
                        if (in_array($field['field_type'], ['float', 'double', 'decimal'])) {
                            $migration_content .= ',' . $field['field_precision'] . ',' . $field['field_scale'];
                        }
                        if (in_array($field['field_type'], ['dateTimeTz', 'dateTime'])) {
                            $migration_content .= ',' . $field['field_precision'];
                        }
                        if (in_array($field['field_type'], ['char'])) {
                            $migration_content .= ',' . $field['field_length'];
                        }
                        $migration_content .= ')';

                        $mail_all_tags_content .= '"value" => "[
                        "type" => "simple",
                        "field_name"=> "' . $field["field_name"] . '",
                        "table"=> "' . $table['table_name'] . '",
                    ]"';
                        if ($field['field_unique'] == true) {
                            $migration_content .= '->unique()';
                        }
                    }
                    $mail_all_tags_content .= "],";
                    $mail_all_tags_content .= "\n";

                    if ($field['field_nullable'] == true) {
                        $migration_content .= '->nullable()';
                    }
                    if ($field['field_default'] == true) {
                        $migration_content .= '->default(' . $field['field_default'] . ')';
                    }

                    $migration_content .= ';';
                    $migration_content .= "\n";

                    // NOTE Table foreign key requests
                    // if ($field['field_unique'] == true) {
                    //     $request_validation_content .= '"' . $field['field_name'] . '"=>"unique:' . $table['table_name'] . '"';
                    //     $request_validation_content .= "\n";
                    // }
                    // if ($field['field_nullable'] != true) {
                    //     $request_validation_content .= '"' . $field['field_name'] . '"=>"required|"';
                    // }
                }

                $migration_content .= '$table->boolean("on_update")->default(false);';
                $migration_content .= '$table->integer("on_update_user_id")->nullable();';
                $migration_content .= '$table->foreignId("user_id")->constrained();';
                $migration_content .= "\n";
                // NOTE Table status => migration
                if ($module_data['contain_validator'] == true) {
                    $migration_content .= '$table->foreignId("status_id")->constrained();';
                    $migration_content .= "\n";

                    // join = table1 (x) + field of table 1 (status_id) + table 2 (statuses) + field of table 2 (id)
                    $mail_all_tags_content .= '
                    "name" => "status",
                        "key" => "name",
                        "group" => "' . $module_name . '",
                        "value" => "[
                            "type" => "simple",
                            "field_name"=> "id",
                            "table"=> "statuses",
                            ]"
                        ';
                    $mail_all_tags_content .= "\n";
                }
                // NOTE Table status => model
                if ($module_data['contain_validator'] == true) {
                    $model_content .= '"status_id",';
                    $model_content .= "\n";
                }

                $relations_string = ModelHelper::getRelationsString($table['fields']);
                $model_content .= '"created_at",
                "updated_at",
                ];';
                $model_content .= "\n";
                $model_content .= 'public $timestamps = true;';
                $model_content .= "\n";
                $model_content .= '

            public function created_by(){
                return $this->belongsTo(User::class, "user_id");
            }' . PHP_EOL;
                if ($table['table_contain_barcode'] == true) {
                    $model_content .= '

                public function barcode(){
                    return $this->hasOne(Barcode_assignment::class);
                }
                ';
                }
                if ($table['table_contain_numbering'] == true) {
                    $model_content .= '
            public function number(){
                return $this->hasOne(Numbering_assignment::class);
            }
            ';
                }
                if ($module_data['contain_validator'] == true) {
                    $model_content .= '
                public function status(){
                    return $this->hasone(Status::class,"status_id","id");
                }
            ';
                }

                $model_content .= '
            public function comments(){
                return $this->hasMany(Comment::class,"app_module_id","id");
            }

            public function files(){
                return $this->hasMany(Upload::class,"app_module_id","id");
            }

            public function reminders(){
                return $this->hasMany(Reminder::class,"app_module_id","id");
            }

            ';

                $model_content .= '// Relations';
                $model_content .= "\n";
                $model_content .= $relations_string;
                $model_content .= '}';
                // Numbering interface
                $request_validation_content .= ",\n];";

                // ANCHOR Add generated data to model ✓

                $model_file = base_path('Modules/' . $module_name . '/Entities/' . $model_name . '.php');
                File::put($model_file, $model_content);

                // ANCHOR Add generated data to migration ✓

                $migration_file_ends = $migration_file_name . '.php';
                $migration_base_path = base_path('Modules/' . $module_name . '/Database/Migrations');

                $migration_file_name = $this->getFileName($migration_base_path, $migration_file_ends);
                $migration_file_path = base_path('Modules/' . $module_name . '/Database/Migrations/' . $migration_file_name);
                file_put_contents($migration_file_path, implode(
                    '',
                    array_map(function ($data) use ($migration_content) {
                        return stristr($data, '$table->id();') ? $migration_content : $data;
                    }, file($migration_file_path))
                ));

                // ANCHOR Migrate
                Artisan::call('module:migrate ' . $module_name);
            }
            // SECTION Validations

            // Create validation

            if ($module_data['contain_validator']) {

                $validation['name'] = $validation_data['name'];
                $validation['require_order'] = $validation_data['order'];
                $validation['user_id'] = Auth::id();
                $validation['app_module_id'] = $module_id;
                Validation::insert($validation);

                $seeder_name_spaces_content .= '
                use App\Models\Validation;
                use App\Models\Permission;
                ';
                $seeder_content .= 'Validation::insert([
                "name"=>' . $validation_data["name"] . ',
                "require_order"=>' . $validation_data["require_order"] . ',
                "user_id"=>' . Auth::id() . ',
                "app_module_id"=> $app_module_id]);
                ';

                $validation_id = DB::getPdo()->lastInsertId();
                // Create statuses +steps + permission
                $seeder_name_spaces_content .= 'use App\Models\Status;';
                $seeder_name_spaces_content .= 'use App\Models\Permission;';
                $seeder_name_spaces_content .= 'use App\Models\ValidationStep;';
                foreach ($validation_data['validations'] as $validation) {
                    $status['name'] = $validation['status_name'];
                    // $status['color'] = "secondary";
                    $status['color'] = $validation['status_color'] ?? "secondary";
                    $status['app_module_id'] = $module_id;
                    $status['user_id'] = Auth::id();
                    Status::insert($status);
                    $seeder_content .= '
                        Status::insert([
                    "name"=>' . $validation["status_name"] . ',
                    "color"=>' . $validation['status_color'] ?? "secondary" . ',
                    "user_id"=>' . Auth::id() . ',
                    "app_module_id"=>$app_module_id]);
                    ';

                    $status_id = DB::getPdo()->lastInsertId();

                    $permission['pseudo_name'] = $validation['name'] . '_' . $model_name . '_validation_permission';
                    $permission['category'] = "validation";
                    $permission['app_module_id'] = $module_id;
                    $permission['user_id'] = Auth::id();
                    Permission::insert($permission);
                    $seeder_content .= '
                        Permission::insert([
                    "pseudo_name"=>"' . $validation['name'] . '_' . $model_name . '_validation_permission' . '",
                    "category"=> "validation",
                    "user_id"=>' . Auth::id() . ',
                    "app_module_id"=>$app_module_id]);
                    ';

                    $permission_id = DB::getPdo()->lastInsertId();

                    $validation_step['name'] = $validation['name'];
                    $validation_step['status_id'] = $status_id;
                    $validation_step['step_order'] = $validation['order'];
                    $validation_step['user_id'] = Auth::id();
                    $validation_step['validation_id'] = $validation_id;
                    $validation_step['permission_id'] = $permission_id;

                    ValidationStep::insert($validation_step);
                    $seeder_content .= '
                        ValidationStep::insert([
                    "name"=>' . $validation["name"] . ',
                    "status_id"=>' . $status_id . ',
                    "step_order"=>' . $validation['order'] . ',
                    "validation_id"=>' . $validation_id . ',
                    "user_id"=>' . Auth::id() . ',]);
                    ';

                    if ($validation_step['step_order'] == 0) {
                        $default_status = $status_id;
                    }
                }
            }

            // SECTION Forms

            // Create status
            // Create permission
            // Create validation step
            $numbering_content = '';
            $numbering_update_content = '';
            if ($table['table_contain_numbering'] == true) {
                $date = ($numbering_data['use_today_date'] == true) ? '' : ',$data["' . $numbering_data["date_field"] . '"]';
                $numbering_content = '$data["reference"] = $this->get_numbering($this->options["module_id"]' . $date . ');';
                $numbering_update_content = '$this->update_assignement_number($this->options["module_id"]' . $date . ');';
            }

            // FIXME Validation data
            // FIXME Pdf insert data in database
            // FIXME Pdf get pdf

            // ANCHOR Migrate
            Artisan::call('module:migrate ' . $module_name);

            $validation_content = '

        public function validateData(){

            $this->validate_data();

            if(true){


            }
        }
        ';
            $barcode_content = '';
            $barcode_update_content = '';
            if ($table['table_contain_barcode'] == true) {
                $date = ($numbering_data['use_today_date'] == true) ? '' : ',$data["' . $numbering_data["date_field"] . '"]';
                $barcode_content = '$data["barcode"] = $this->get_barcode($this->options["module_id"]' . $date . ');';
                $barcode_update_content = '$this->update_barcode_assignement_number($this->options["module_id"]' . $date . ');';
            }

            $listing_content = $this->listing_generate_file(Auth::id(), $module_id, ModelHelper::getRelations($this->tables))['controller'];
            $listing_namespaces = $listing_content['namespaces'];
            $mount_content = $listing_content['mount'];
            $methods = $listing_content['methods'];
            $variables = $listing_content['variables'];
            $listeners = $listing_content['listeners'];
            $base_data = $variables['base_data'];
            $filters = $variables['filters'];
            $options = $variables['options'];
            $filterLoops = $variables['filterLoops'];

            // ANCHOR permissions

            if ($template_data['type'] == "separated" and $template_data['value'] == 1) {

                Artisan::call('permission:create ' . $module_pseudo_name . ' basic');
                $seeder_content .= "
                Artisan::call('permission:create $module_pseudo_name basic');";
            } else {
                Artisan::call('permission:create ' . $module_pseudo_name . ' basic');
                Artisan::call('permission:create ' . $module_pseudo_name . ' advanced');
                $seeder_content .= "
                Artisan::call('permission:create $module_pseudo_name basic');
                Artisan::call('permission:create $module_pseudo_name advanced');
                ";
            }

            // ANCHOR Notifications

            $call_for_notifications = '';
            $use_notifications = '';
            $notifications = [];
            // if (count($this->notifications)) {
            //     $call_for_notifications .= 'use Illuminate\Support\Facades\Notification;';
            //     $use_notifications .= '';

            //     foreach ($this->notifications as $notification) {
            //         if ($notification['value'] == true) {
            //             // Possible values : created - edited - validated - deleted
            //             $module_notification = [];
            //             $module_notification['name'] = $module_name . '_' . $notification['value'] . '_notification';
            //             $module_notification['value'] = true;
            //             array_push($notifications, $module_notification);
            //             Artisan::call('module:make-notification ' . $module_notification['name'] . ' ' . $module_name);
            //         }
            //     }
            // }
            $fields = $template_data['fields'];

            $show_cards_value = $template_data['cards'] == false ? "false" : "true";

            $additional_base_data = '';
            $additional_mount_data = '';
            foreach ($fields as $element) {
                $element['app_module_id'] = $module_id;
                if (in_array($element['type'], ['select', 'multiple_select', 'radio', 'checkbox'])) {
                    $additional_base_data .= '"' . $element['column'] . '_options" => [],';
                    $additional_base_data .= "\n";
                }
            }

            $additional_mount_data .= '// Form mount - start' . "\n";

            foreach ($fields as $element) {
                $element['app_module_id'] = $module_id;
                if (in_array($element['type'], ['select', 'multiple_select', 'radio', 'checkbox'])) {

                    if ($element['value']['type'] == 'custom') {
                        $additional_mount_data .= '
                        $this->base_data["' . $element['column'] . '_options"] = DropDown::select("select_id as id", "select_value as text")->where("select_field", "' . $element['column'] . '")->where("app_module_id", $this->options["module_id"])->where("select_field", "' . $element["column"] . '")->get()->toArray();';

                        $additional_mount_data .= "\n";
                    } else {
                        $table_pseudo_name = (in_array($element['value']['table'], Modelhelper::default_modules) ? $element['value']['table'] : Str::replace('_', '', Str::plural($element['value']['table'])));
                        // $additional_mount_data .= '$this->base_data["' . $element['column'] . '_options"] = ' . ModelHelper::getModelName($element['value']['table']) . '::select("id", "' . $element['value']['column'] . ' as text")->get()->toArray();';
                        if ($element['value']['table'] == 'drop_downs') {
                            $additional_mount_data .= '$this->base_data["' . $element['column'] . '_options"] = \\' . ModelHelper::getModelStringByTableNameAndModule($element['value']['table'], $table_pseudo_name) . '::select("id", "' . $element['value']['column'] . ' as text")->where("select_field", "' . $element["column"] . '")->get()->toArray();';
                        } else {
                            $additional_mount_data .= '$this->base_data["' . $element['column'] . '_options"] = \\' . ModelHelper::getModelStringByTableNameAndModule($element['value']['table'], $table_pseudo_name) . '::select("id", "' . $element['value']['column'] . ' as text")->get()->toArray();';
                        }

                        $additional_mount_data .= "\n";
                    }
                }
            }

            $additional_mount_data .= '// Form mount - end' . "\n";

            $form_display = '';
            $form_content = '// Form values - start' . "\n";

            foreach ($fields as $field) {
                $form_content .= '"' . $field['column'] . '" => "",';
                $form_content .= "\n";
            }

            $form_content .= '// Form values - end' . "\n";

            if ($template_data['type'] == "separated" and $template_data['value'] == 1) {
                $content_display = 'show_modal';
                $additional_options_data = '';
                $additional_methods = '';
                $form_display = 'show_modal';
            } else {
                $content_display = 'show_content';
                $form_display = 'show_form';
                $additional_options_data = '
            "modal" => [
                "show" => false,
                "current" => "",
                "title" => "",
            ],
            "currentElement" => [],
            "show_form" => false,
            "show_content" => false,
            "show_dropdown" => false,
            "title_content" => "",
            "status_content" => "",
            "status_color_content" => "",
            ';
                $additional_base_data = '
            "content" => [
                "reminder" => [
                    "columns" => ["From", "To", "Description", "Date Added", "Date of reminder", "By email", "options"],
                    "columns_keys" => ["from", "to", "description", "date_added", "date_of_reminder", "by_email", "options"],
                    "data" => [],
                ],
                "files" => [
                    "columns" => ["Name", "Size", "Visibility", "Uploaded At", "options"],
                    "columns_keys" => ["name", "size", "visibility", "uploaded_at", "options"],
                    "data" => [],
                ],
            ],
            "users" => [],';
                $form_content .= '
            "reminders" => [
                "date" => "",
                "by_email" => false,
                "user" => "",
                "value" => "",
            ],
            "upload_file" => [
                "files" => [],
            ],
            "comments" => [
                "value" => "",
                "rows" => [],
            ],';
                $additional_methods = '
            public function _edit()
            {
                $this->req(function () {
                    foreach ($this->options["currentElement"] as $key => $value) {
                        if (isset($this->form[$key]))
                            $this->form[$key] = $value;
                    }
                    $this->action_options("show_form");
                });
            }
            ';
            }
            $controller_content = '';
            $controller_content .= '<?php
        namespace Modules\\' . $module_name . '\\Http\Livewire;

        use Livewire\Component;
        use Modules\\' . $module_name . '\\Entities\\' . $model_name . ';
        use DB;
        use Auth;
        use Carbon\Carbon;
        use App\Models\Form;
        use App\Models\DropDown;
        use App\Models\AppModule;
        use Throwable;
        use App\Helpers\DateHelper;
        use App\Helpers\LogHelper;
        use App\Helpers\StringHelper;
        use App\Helpers\ModelHelper;
        use App\Models\CustomFilter;
        use App\Models\Upload;
        use App\Models\User;
        ' . $listing_namespaces . '
        use DataTables;
        ' . $call_for_notifications . '

        use App\Traits\AppTrait;
        use App\Traits\GeneralTrait;
        use Livewire\WithFileUploads;

        class ' . $module_name . ' extends Component
        {

            ' . $use_notifications . '
            use AppTrait;
            use GeneralTrait;
            use WithFileUploads;

            protected $listeners = [
                ' . $listeners . '
                "alertResult",
            ];

            public $base_data = [
                ' . $base_data . '
                "buttons" => [
                    "add" => " ' . $model_name . '",
                ],
                "permissions" => [],
                "app_module" => [],
                "permissions" => [],
                "user" => null,
                ' . $additional_base_data . '
                "module_pseudo_name" => "' . $module_pseudo_name . '",
                "route" => [
                    "url" => "",
                    "basename" => "",
                ],
            ];

            public $time = null;
            public $filters = [
                ' . $filters . '
            ];
            public $form = [
                ' . $form_content . '
            ];
            public $filterLoops = [
                ' . $filterLoops . '
            ];
            public $formElements = [];
            public $showCards = ' . $show_cards_value . ';

            public $options = [
                ' . $options . '
                "helper" => "' . $module_name . 'Helper",
                "title_content" => "",
                "currentElement" => [],
                "status_content" => "",
                "status_color_content" => "",
                "modal" => [
                    "show" => false,
                    "current" => "",
                    "title" => "",
                ],
                "element-length" => 12,
                "module_name"=>"' . $module_name . '",
                ' . $additional_options_data . '
            ];

            public function render()
            {
                return view("' . strtolower($module_name) . '::livewire.manage");
            }

            public function mount(){
                $this->base_data["route"]["url"] = url()->current();
                $this->base_data["route"]["basename"] = basename($this->base_data["route"]["url"]);
                $this->base_data["permissions"] = $this->getPermissions();
                if(!$this->base_data["permissions"]["view"] AND !$this->base_data["permissions"]["view_own"]){
                    abort(403);
                }
                ' . $mount_content . '
                ' . $additional_mount_data . '

                $module_class = new ' . $model_name . ';
                $this->appOptions["subject"] = [
                    "id" => null,
                    "type" => get_class($module_class),
                    "name" => class_basename($module_class),
                ];
                $this->base_data[\'user\'] = Auth::user();
                $this->base_data["app_module"] = AppModule::where("id", $this->options["module_id"])->first()->toArray();
                $this->appOptions["app_module_id"] = $this->options["module_id"];
                $this->appValues["upload_file"]["files"] = Upload::_get_by_module($this->options["module_id"])->toArray();
            }

            ' . $methods . '

            public function save(){
                $this->req(function () {
                    // Try & catch
                    DB::beginTransaction();
                    // $validated = $form->validated();';

            $controller_content .= "\n";
            $controller_content .= '// Form save values - start' . "\n";

            foreach ($fields as $field) {
                $controller_content .= '$data["' . $field['column'] . '"] = $this->form["' . $field['column'] . '"];';
                $controller_content .= "\n";
            }

            $controller_content .= '// Form save values - end' . "\n";
            $controller_content .= '
                if($this->options["id"] == ""){
                    if(!$this->base_data["permissions"]["create"]){
                        $this->showAlert("error", "Permission Denied");
                        abort(403);
                    }
                    try {
                        // Validate the value...

                        ' . $numbering_content . '
                        ' . $barcode_content . '
                        $data["user_id"] = Auth::id();
                        $data["created_at"] = Carbon::now()->toDateTimeString();
                        ';
            if ($module_data['contain_validator']) {
                $controller_content .= '$data["status_id"]=' . $default_status . ';';
            }
            $controller_content .= "\n";

            $controller_content .= $model_name . '::insert($data);
                            $insert_id = DB::getPdo()->lastInsertId();
                            if(isset($insert_id)){
                                ' . $numbering_update_content . '
                                ' . $barcode_update_content . '
                                DB::commit();
                                $this->cancel();
                                LogHelper::setLog("created", ' . $model_name . '::find($insert_id));
                                $this->showSlideAlert("success", "' . $model_name . ' added successfully");
                                $this->reloadTable($this->base_data["module_name"]);
                            }else {
                                $this->showAlert("error", "Problem encountred");
                                DB::rollback();
                                return false;
                            }

                        } catch (Throwable $e) {
                            $this->showAlert("error", $e->getMessage());
                            report($e);
                            DB::rollback();
                            return false;
                        }
                    }elseif(is_int($this->options["id"])){
                        // update
                        if(!$this->base_data["permissions"]["update"]){
                            $this->showAlert("error", "Permission Denied");
                            abort(403);
                        }
                        try {
                            // Validate the value...
                            ' . $model_name . '::where("id",$this->options["id"])->update($data);
                            LogHelper::setLog("updated", ' . $model_name . '::find($this->options["id"]));
                            DB::commit();
                            $this->cancel();
                            $this->showSlideAlert("success", "' . $model_name . ' updated successfully");
                            $this->reloadTable($this->base_data["module_name"]);
                        } catch (Throwable $e) {
                            $this->showAlert("error", $e->getMessage());
                            report($e);
                            DB::rollback();
                            return false;
                        }
                    }
                    else{
                        abort(404);
                    }
                });
            }

            public function editData($id) {
                $this->req(function () use ($id) {
                    if(!$this->base_data["permissions"]["update"]){
                        abort(403);
                    }

                    $is_on_update = ModelHelper::setModuleUpdate($this->base_data["module_pseudo_name"], $id, true, function ($user) {
                        $this->showAlert("warning", $user->first_name . " " . $user->last_name . " " . __("is updating this!"));
                    });

                    if (!$is_on_update) return;

                    $' . strtolower($model_name) . ' = ' . $model_name . '::findOrFail($id);';
            $controller_content .= "\n";
            $controller_content .= '// Form edit values - start' . "\n";

            foreach ($fields as $field) {
                $controller_content .= '$this->form["' . $field['column'] . '"] = $' . strtolower($model_name) . '->' . $field['column'] . ';';
                $controller_content .= "\n";
            }

            $controller_content .= '// Form edit values - end' . "\n";
            $controller_content .= '
                    $this->options["id"] = $id;
                    $this->action_options("' . $form_display . '");
                });
            }';
            if ($template_data['type'] == "separated" and $template_data['value'] == 1) {

                $controller_content .= '';
            } else {
                $with_content = '"comments", "reminders"';
                if ($module_data['contain_validator']) {
                    $with_content .= ',"status"';
                }

                $controller_content .= '
                public function show_row($id){
                    $this->req(function () use ($id) {
                        $this->options["id"] = $id;
                        $this->appOptions["id"] = $id;
                        $this->appOptions["subject"]["id"] = $id;
                        $this->options["currentElement"] = ' . $model_name . '::where("id",$id)->with(' . $with_content . ')->first()->toArray();
                        $this->appValues["comments"]["rows"] = Comment::_get_by_module($this->options["module_id"], $id);

                        $this->options["title_content"] = $this->options["currentElement"]["reference"] ?? "' . $model_name . '";

                        if(isset($this->options["currentElement"]["status_id"])){
                            $this->options["status"] =  true ;
                            $this->options["status_content"] = $this->options["currentElement"]["status"]["name"] ?? "";
                            $this->options["status_color_content"] = $this->options["currentElement"]["status"]["color"] ?? "";
                        }
                        else $this->options["status"] =  false ;

                        $this->action_options("show_content");
                    });
                }';
            }
            $controller_content .= $additional_methods;
            $controller_content .= '

            public function deleteData($id)
            {
                $this->req(function () use ($id) {
                    if(!$this->base_data["permissions"]["delete"]){
                        $this->showAlert("error", "Permission Denied");
                        abort(403);
                    }

                    $this->options["id"] = $id;
                    $this->showAlert("question", "Are you sure?", "delete");
                });
            }

            public function validateData($id) {
                $this->req(function () use ($id) {
                    dd("validate");
                });
            }

            public function printData($id) {
                $this->req(function () use ($id) {
                    dd("validate");
                });
            }

            public function save_option() {
                $this->req(function () {
                    if ($this->options["modal"]["current"] == "comments") {
                        $this->saveComment();
                    } else if ($this->options["modal"]["current"] == "reminders") {
                        $this->saveReminder();
                    }
                });
            }

            public function cancel()
            {
                $this->req(function () {
                    if ($this->options["id"] != null) {
                        ModelHelper::setModuleUpdate($this->base_data["module_pseudo_name"], $this->options["id"], false);
                    }

                    foreach ($this->form as $key => $value) {
                        $type = gettype($value);
                        if ($type == "string") {
                            $this->form[$key] = "";
                        } else if (in_array($type, ["integer", "float", "double"])) {
                            if (str_contains($key, "_id"))
                                $this->form[$key] = "";
                            else
                                $this->form[$key] = 0;
                        } else if ($type == "array") {
                            $this->form[$key] = [];
                        } else {
                            $this->form[$key] = null;
                        }
                    }

                    $this->appOptions["id"] = null;
                    $this->appOptions["subject"]["id"] = null;
                    $this->dispatchBrowserEvent("reloadSelect");
                    $this->action_options("' . $form_display . '");
                });
            }
            // NOTE - Option methods
            // public function action_options($name)
            // {
            //     $this->req(function () use ($name) {
            //         $this->options[$name] = !$this->options[$name];
            //     });
            // }

            private function setData(){
                $form = Form::where("module_id",' . $module_id . ')->first();
                $this->formElements = unserialize($form->value);
                $this->base_data["columns"] = [];
                $this->base_data["data"] = [];
            }

            private function getPermissions()
            {
                $user_id = Auth::id();

                return [
                    "view" => has_permission(module_permission_name($this->options["module_name"], "view"), $user_id),
                    "view_own" => has_permission(module_permission_name($this->options["module_name"], "view_own"), $user_id),
                    "create" => has_permission(module_permission_name($this->options["module_name"], "create"), $user_id),
                    "update" => has_permission(module_permission_name($this->options["module_name"], "update"), $user_id),
                    "delete" => has_permission(module_permission_name($this->options["module_name"], "delete"), $user_id),
                    "view_comments" => has_permission(module_permission_name($this->options["module_name"], "view_comments"), $user_id),
                    "create_comments" => has_permission(module_permission_name($this->options["module_name"], "create_comments"), $user_id),
                    "view_reminders" => has_permission(module_permission_name($this->options["module_name"], "view_reminders"), $user_id),
                    "create_reminders" => has_permission(module_permission_name($this->options["module_name"], "create_reminders"), $user_id),
                    "view_file_upload" => has_permission(module_permission_name($this->options["module_name"], "view_file_upload"), $user_id),
                    "create_file_upload" => has_permission(module_permission_name($this->options["module_name"], "create_file_upload"), $user_id),
                ];
            }

            // NOTE - Alert functions
            public function alertResult($result)
            {
                $this->req(function () use ($result) {
                    if ($result) {
                        if ($this->appOptions["alert"]["target"] == "delete") {
                            LogHelper::setLog("deleted", ' . $model_name . '::find($this->options["id"]));
                            ' . $model_name . '::where("id", $this->options["id"])->delete();
                            $this->showSlideAlert("success", "' . $model_name . ' deleted successfully");
                            $this->reloadTable($this->base_data["module_name"]);
                        }
                    }

                    $this->options["id"] = null;
                }, [
                    "hide_alert" => true,
                ]);
            }
            // NOTE - End alert functions
        }
        ';

            // dd($controller_content);

            // ANCHOR Create livewire directory for controllers
            File::makeDirectory(base_path('Modules/' . $module_name . '/Http/Livewire'));

            $module_livewire_controller = base_path('Modules/' . $module_name . '/Http/Livewire/' . $module_name . '.php');

            File::put($module_livewire_controller, $controller_content);

            // index
            // save
            // delete
            // api

            // ANCHOR Create livewire directory for views
            File::makeDirectory(base_path('Modules/' . $module_name . '/Resources/views/livewire'));
            if ($template_data['type'] == 'separated') {
                $cards_template = base_path('resources/views/livewire/includes/base/cards.blade.php');
                $script_template = base_path('resources/views/livewire/includes/base/script.blade.php');
                if ($template_data['value'] == 1) {
                    $views_template = "template-demo1.blade.php";
                    $form_template = base_path('resources/views/livewire/includes/base/form-demo1.blade.php');
                } else {
                    $preview_template = base_path('resources/views/livewire/includes/base/preview.blade.php');
                    $preview_module_file = base_path('Modules/' . $module_name . '/Resources/views/livewire/preview.blade.php');
                    File::copy($preview_template, $preview_module_file);
                    if ($template_data['value'] == 2) {
                        $views_template = "template-demo4.blade.php";
                        $form_template = base_path('resources/views/livewire/includes/base/form-demo4.blade.php');
                    } elseif ($template_data['value'] == 3) {
                        $views_template = "template-demo3.blade.php";
                        $form_template = base_path('resources/views/livewire/includes/base/form-demo3.blade.php');
                    } elseif ($template_data['value'] == 4) {
                        $views_template = "template-demo2.blade.php";
                        $form_template = base_path('resources/views/livewire/includes/base/form-demo2.blade.php');
                    }
                }
            } elseif ($template_data['type'] == 'global') {
                $views_template = "global-template.blade.php";
            }
            $modal_form_views_template_directory = base_path('resources/views/livewire/' . $views_template);
            $manage_module_file = base_path('Modules/' . $module_name . '/Resources/views/livewire/manage.blade.php');
            $cards_module_file = base_path('Modules/' . $module_name . '/Resources/views/livewire/cards.blade.php');
            $script_module_file = base_path('Modules/' . $module_name . '/Resources/views/livewire/script.blade.php');
            $form_module_file = base_path('Modules/' . $module_name . '/Resources/views/livewire/form.blade.php');
            File::copy($modal_form_views_template_directory, $manage_module_file);
            File::copy($cards_template, $cards_module_file);
            File::copy($script_template, $script_module_file);
            File::copy($form_template, $form_module_file);

            // ANCHOR RouteServiceProvider
            $route_service_provider_path = base_path('Modules/' . $module_name . '/Providers/RouteServiceProvider.php');
            file_put_contents($route_service_provider_path, implode(
                '',
                array_map(function ($data) {
                    return stristr($data, 'protected $moduleNamespace = ' . 'Http\Controllers') ? 'Http\Livewire' : $data;
                }, file($route_service_provider_path))
            ));

            // ANCHOR Routes

            $gate = Gate::find($app_module['activate_duplicate']);
            $route_web_path = base_path('Modules/' . $module_name . '/Routes/web.php');
            $new_route_content = 'Route::group(["middleware"=>"' . $gate->prefix . 'Middlware","prefix"=>"' . strtolower($module_name) . '","as"=>"' . $gate->prefix . '"."' . strtolower($module_name) . '."],function(){
                Route::get("/", ' . $module_name . '::class)->name("index");
            })';
            $new_route_livewire = '
                Route::get("", ' . $module_name . '::class);
                Route::post("list", "' . $module_name . '@generateData")->name("' . $module_pseudo_name . '.list");
            ';
            if ($template_data['type'] == 'separated' && $template_data['value'] != 1) {
                $new_route_livewire .= 'Route::post("list_join_files", "' . $module_name . '@getJoinFiles")->name("' . $module_pseudo_name . '.join_files");';
                $new_route_livewire .= 'Route::post("list_reminders", "' . $module_name . '@getReminders")->name("' . $module_pseudo_name . '.reminders");';
            }
            file_put_contents($route_web_path, implode(
                '',
                array_map(function ($data) use ($module_name, $new_route_livewire) {
                    return stristr($data, "Route::get('/', '" . $module_name . "Controller@index');") ? $new_route_livewire : $data;
                }, file($route_web_path))
            ));

            // ANCHOR Form
            // ANCHOR save dropdowns
            // FIXME Seeder for dropdown
            $seeder_name_spaces_content .= 'use App\Models\DropDown;';
            foreach ($fields as $field) {
                if (in_array($field['type'], ['select', 'multiple_select', 'radio', 'checkbox']) and $field['value']['type'] == 'custom') {
                    foreach ($field['value']['custom'] as $value) {

                        $table = $this->getTableByKey($field['table']);
                        $dropdown_data['select_table'] = $table['table_name'];
                        $dropdown_data['select_field'] = $field['column'];
                        $dropdown_data['select_id'] = $value['value'];
                        $dropdown_data['select_value'] = $value['text'];
                        $dropdown_data['app_module_id'] = $module_id;
                        $dropdown_data['user_id'] = Auth::id();
                        DropDown::insert($dropdown_data);
                        $seeder_content .= 'DropDown::insert([
                            "select_table"=>"' . $table['table_name'] . '",
                            "select_field"=>"' . $field['column'] . '",
                            "select_id"=>"' . $value['value'] . '",
                            "select_value"=>"' . $value['text'] . '",
                            "app_module_id"=>$app_module_id,
                            "user_id"=>' . Auth::id() . ',
                        ]);';
                    }
                }
            }
            // ANCHOR save form data
            $form_data['name'] = $module_name . '_basic_form';
            $form_data['app_module_id'] = $module_id;
            $form_data['user_id'] = Auth::id();
            $form_data['value'] = serialize($fields);
            $form_data['path'] = 'Modules/' . $module_name . '/Resources/views/livewire/form.blade.php';
            $seeder_name_spaces_content .= 'use App\Models\Form;';
            $seeder_content .= 'Form::insert([
                "name"=>"' . $module_name . '_basic_form' . '",
                "app_module_id"=>$app_module_id,
                "user_id"=>' . Auth::id() . ',
                "value"=>\'' . serialize($fields) . '\',
                "path"=>"Modules/' . $module_name . '/Resources/views/livewire/form.blade.php",
            ]);';
            Form::insert($form_data);

            // NOTE - Save fields to view
            FileHelper::put_view_content($fields, (object) [
                'form' => $form_data['path'],
                'manage' => 'Modules/' . $module_name . '/Resources/views/livewire/manage.blade.php',
            ], $template_data['target_save_fields'], $module_id);

            // File::put($form_data['path'], $form_content);
            // file_put_contents($module_livewire_views, implode(
            //     '',
            //     array_map(function ($data) use ($form_content) {
            //         return stristr($data, "{{-- form --}}") ? $form_content : $data;
            //     }, file($module_livewire_views))
            // ));

            // ANCHOR Add dropdowns as seeders for the module

            // ANCHOR
            foreach ($relation_data as $relation) {
                $content = '// Relations';
                $content .= "\n";
                $first_model = ucfirst(substr($relation['second_model'], 0, -1));
                $second_model = ucfirst(substr($relation['second_model'], 0, -1));
                $content .= 'public function ' . $second_model . '()
            {
                return $this->' . $relation['relation_type'] . '(' . $second_model . '::class);
            }';
                $content .= "\n";

                $model_file = base_path('Modules/' . $first_model . '/Entities/' . $first_model . '.php');
                if (!file_exists($model_file)) {
                    $model_file = base_path('app/Models/' . $first_model . '.php');
                }
                file_put_contents($model_file, implode(
                    '',
                    array_map(function ($data) use ($content) {
                        return stristr($data, '// Relations') ? $content : $data;
                    }, file($model_file))
                ));
            }

            // ANCHOR Email method content
            //     [
            //         'name'      => 'company_name',
            //         'key'       => 'company_name',
            //         'group'       => 'company',
            //         'value'       => [
            //             'type' => 'global',
            //             'key_field_name'=> 'key',
            //             'value_field_name'=> 'value',
            //             'table'=> 'settings',

            // ],

            $mail_class_content = 'public function get_all_tags()
        {
          $all_tags = [' . $mail_all_tags_content . '];

             return $all_tags;
        }
      }';

            // NOTE - Events
            $event_name = $module_name . 'Event';
            $listener_name = $module_name . 'Listener';
            Artisan::call('module:make-event ' . $event_name . ' ' . $module_name);
            Artisan::call('module:make-listener ' . $listener_name . ' ' . $module_name);
            FileHelper::addModuleEventInProvider($module_name, $event_name, $listener_name);

            // NOTE - Replace in files
            FileHelper::replaceOneLineFileContent(
                'Modules/' . $module_name . '/Providers/RouteServiceProvider.php',
                'protected $moduleNamespace = \'Modules\\' . $module_name . '\Http\Livewire\';',
                'protected $moduleNamespace = \'Modules\\' . $module_name . '\Http\Controllers\';'
            );

            FileHelper::replaceOneLineFileContent(
                'Modules/' . $module_name . '/Routes/web.php',
                'Route::prefix(\'' . $module_pseudo_name . '\')->middleware(\'auth\')->group(function() {',
                'Route::prefix(\'' . $module_pseudo_name . '\')->group(function() {'
            );

            // NOTE - Save setting
            $new_menu_order = Menu::getLastOrder() + 1;
            $menu_permission_id = Permission::getPermissionByPseudo('view_' . $module_pseudo_name . '_permission', 'id');

            Menu::_save([
                'category' => 'simple',
                // 'icon' => '',
                'name' => $module_name,
                'path' => '/' . $module_pseudo_name,
                // 'source' => '',
                'item_order' => $new_menu_order,
                'permission_id' => $menu_permission_id,
            ]);

            $seeder_name_spaces_content .= 'use App\Models\Menu;';
            $permission_name_for_menu = 'Permission::select("id")->where("pseudo_name","view_own_' . $module_pseudo_name . '_permission")->first()->id';
            $seeder_content .= 'Menu::insert([
                "category" => "simple",
                // "icon" => "",
                "name" => "' . $module_name . '",
                "path" => "/' . $module_pseudo_name . '",
                // "source" => "",
                "item_order" => ' . $new_menu_order . ',
                "permission_id" => "' . $permission_name_for_menu . '",
                "user_id" => 1,
            ]);';
            $this->listing_save($module_id);

            // DB::commit();
            $this->cancel();
            $this->showSlideAlert('success', 'Module created successfully!');

            // NOTE - After save module
            $this->getSupportedData();

            //NOTE INsert seeder content

            FileHelper::replaceOneLineFileContent($seeder_path, $seeder_content, 'Model::unguard();');
            FileHelper::replaceOneLineFileContent($seeder_path, $seeder_name_spaces_content, 'use Illuminate\Database\Seeder;');
        } catch (\Exception $e) {
            if ($module_id != null) {
                AppModule::_delete($module_id);
            }

            // DB::rollback();
            // dd($e);
            $this->showAlert('error', $e->getMessage() . ' - (File: ' . basename($e->getFile()) . ', Line: ' . $e->getLine() . ')');
        }

        //TODO - Create permission

        //
        // dd($request_validation_content, $model_content, $migration_content);
        // dd($this->tables, $this->values, $this->listing);
    }

    // NOTE - Cancel module
    public function cancel()
    {
        $this->values = [
            'module' => [
                'name' => '',
                'description' => '',
                'empty_when_reinitializating' => false,
                'contain_validator' => false,
                'emailing' => false,
                'notifications' => false,
                'pdf' => false,
                'contain_importation' => false,
                'gate' => '',
            ],
            'relations' => [],
            'template' => [
                'type' => '',
                'value' => '',
                'cards' => false,
                'fields' => [],
                'target_save_fields' => 'file',
            ],
            'numbering' => [
                'choose_column' => false,
                'table' => '',
                'column' => '',
                'custom_number' => false,
                'number_initiator' => 1,
                'use_numbering' => '',
                'random' => '',
                'every-day' => false,
                'every-week' => false,
                'every-month' => false,
                'every-year' => false,
                'use_today_date' => false,
                'number_length' => 0,
                'date_field' => '',
                'form' => [
                    'name' => '',
                    'type' => 'standard',
                    'text' => '',
                    'value' => '',
                ],
                'elements' => [
                    [
                        'name' => 'Number',
                        'type' => 'static',
                    ],
                ],
            ],
            'barcode' => [
                'choose_column' => false,
                'table' => '',
                'column' => '',
                'type' => '',
                'custom_number' => false,
                'number_initiator' => 1,
                'use_numbering' => '',
                'random' => '',
                'every-day' => false,
                'every-week' => false,
                'every-month' => false,
                'every-year' => false,
                'use_today_date' => false,
                'number_length' => 0,
                'date_field' => '',
                'form' => [
                    'barcode_type' => '',
                    'name' => '',
                    'type' => 'standard',
                    'text' => '',
                    'value' => '',
                ],
                'elements' => [
                    [
                        'name' => 'Barcode',
                        'type' => 'static',
                    ],
                ],
            ],
            'validator' => [
                'name' => '',
                'order' => false,
                'validations' => [],
            ],
            'notification' => [
                'created' => false,
                'edited' => false,
                'deleted' => false,
            ],
        ];

        $this->options['selected_step'] = 1;
        $this->options['selected_backup_file'] = '';
        $this->options['errors'] = [
            'module_name' => [
                'show' => false,
                'message' => '',
            ],
            'template_type' => [
                'show' => false,
                'message' => '',
            ],
            'template_value' => [
                'show' => false,
                'message' => '',
            ],
            'validator_name' => [
                'show' => false,
                'message' => '',
            ],
        ];
        $this->base_data['form']['columns'] = [];
        $this->base_data['form']['value'] = [
            'columns' => [],
        ];
        $this->tables = [];
        $this->listing_cancel();
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function cancelBackup()
    {
        $this->options['selected_backup_file'] = '';
        $this->action_options('show_modal_backups');
    }

    // NOTE - Get backup
    public function getBackup()
    {
        $file = $this->options['selected_backup_file'];

        if ($file != '') {
            $this->getBackupFile($file);
        }
    }

    private function getBackupFile($module_name)
    {
        $text = File::get(base_path('Modules/Backups/' . $module_name . '.txt'));
        $backup = @unserialize($text) ? unserialize($text) : [];

        if (count($backup) > 0) {
            foreach ($backup['base_data'] as $key => $value) {
                if (isset($this->base_data[$key])) {
                    $this->base_data[$key] = $backup['base_data'][$key];
                }
            }
            // $this->base_data = $backup['base_data'];
            foreach ($backup['values'] as $key => $value) {
                if (isset($this->values[$key])) {
                    $valueType = gettype($value);
                    if ($valueType == 'array') {
                        foreach ($value as $key_2 => $value_2) {
                            $this->values[$key][$key_2] = $value_2;
                        }
                    } else {
                        $this->values[$key] = $backup['values'][$key];
                    }
                }
            }
            // $this->values = $backup['values'];
            $this->tables = $backup['tables'];
            $this->listing = $backup['listing'];
            $this->action_options('show_modal_backups');
        } else {
            dd('Array is empty!');
        }
    }

    // NOTE - Helper functions
    public function action_options($name)
    {
        $this->options[$name] = !$this->options[$name];
    }

    public function alertResult($result)
    {
        $this->hideAlert();
    }

    // NOTE - Listing functions

    // NOTE - Private functions
    private function checkData($step)
    {
        // dd($this->values, $this->tables);
        switch ($step) {
            case 1:
                $is_data_not_empty = $this->isDataNotEmpty($this->values['module'], [
                    [
                        'key' => 'name',
                        'error' => 'module_name',
                        'message_name' => 'Module name',
                    ],
                ]);

                if (!$is_data_not_empty) {
                    return false;
                }

                $is_data_exists = $this->isDataExists($this->values['module'], [
                    [
                        'key' => 'name',
                        'db_key' => 'name',
                        'table' => 'AppModule',
                        'error' => 'module_name',
                        'message_name' => 'Module name',
                    ],
                ]);

                if ($is_data_exists) {
                    return false;
                }

                return true;
                break;

            case 2:
                $result = true;

                foreach ($this->tables as $key => $table) {
                    if (
                        !$this->isDataNotEmpty($table, [
                            [
                                'index' => $key,
                                'base_data' => 'tables',
                                'key' => 'table_name',
                                'error_in_data' => true,
                                'message_name' => 'Table name',
                            ],
                        ])
                    ) {
                        $result = false;
                    }

                    foreach ($table['fields'] as $key_2 => $field) {
                        if ($field['field_seconday_key']) {
                            $checkArray = [
                                [
                                    'index' => $key,
                                    'index2' => $key_2,
                                    'base_data' => 'fields',
                                    'key' => 'field_name',
                                    'error_in_data' => true,
                                    'message_name' => 'Field name',
                                ],
                            ];
                        } else {
                            $checkArray = [
                                [
                                    'index' => $key,
                                    'index2' => $key_2,
                                    'base_data' => 'fields',
                                    'key' => 'field_name',
                                    'error_in_data' => true,
                                    'message_name' => 'Field name',
                                ],
                                [
                                    'index' => $key,
                                    'index2' => $key_2,
                                    'base_data' => 'fields',
                                    'key' => 'field_type',
                                    'error_in_data' => true,
                                    'message_name' => 'Field type',
                                ],
                            ];
                        }

                        if (!$this->isDataNotEmpty($field, $checkArray)) {
                            $result = false;
                        }

                        if ($this->checkNameOfColumn($field, [
                            [
                                'index' => $key,
                                'index2' => $key_2,
                                'base_data' => 'fields',
                                'key' => 'field_name',
                                'error_in_data' => true,
                                'message_name' => 'Field name',
                            ],
                        ])) {
                            $result = false;
                        }
                    }
                }

                return $result;
                break;

            case 3:
                $result = true;

                foreach ($this->values['relations'] as $key => $relation) {
                    if (!$this->isDataNotEmpty($relation, [
                        [
                            'index' => $key,
                            'base_data' => 'relations',
                            'key' => 'first_model',
                            'error_in_data' => true,
                            'message_name' => 'First model',
                        ],
                        [
                            'index' => $key,
                            'base_data' => 'relations',
                            'key' => 'relation_type',
                            'error_in_data' => true,
                            'message_name' => 'Relation type',
                        ],
                        [
                            'index' => $key,
                            'base_data' => 'relations',
                            'key' => 'second_model',
                            'error_in_data' => true,
                            'message_name' => 'Second model',
                        ],
                    ])) {
                        $result = false;
                    }
                }

                return $result;
                break;

            case 4:
                $result = true;

                if (!$this->isDataNotEmpty($this->values['template'], [
                    [
                        'key' => 'type',
                        'error' => 'template_type',
                        'message_name' => 'Type',
                    ],
                ])) {
                    $result = false;
                }

                if ($this->values['template']['type'] == 'separated') {
                    if (!$this->isDataNotEmpty($this->values['template'], [
                        [
                            'key' => 'value',
                            'error' => 'template_value',
                            'message_name' => 'Template',
                        ],
                    ])) {
                        $result = false;
                    }
                }

                foreach ($this->values['template']['fields'] as $key => $field) {
                    if (!$this->isDataNotEmpty($field, [
                        [
                            'index' => $key,
                            'base_data' => 'forms',
                            'key' => 'table',
                            'error_in_data' => true,
                            'message_name' => 'Table',
                        ],
                        [
                            'index' => $key,
                            'base_data' => 'forms',
                            'key' => 'column',
                            'error_in_data' => true,
                            'message_name' => 'Column',
                        ],
                        [
                            'index' => $key,
                            'base_data' => 'forms',
                            'key' => 'label',
                            'error_in_data' => true,
                            'message_name' => 'Label',
                        ],
                        [
                            'index' => $key,
                            'base_data' => 'forms',
                            'key' => 'type',
                            'error_in_data' => true,
                            'message_name' => 'type',
                        ],
                    ])) {
                        $result = false;
                    }
                }

                return $result;
                break;

            case 10:
                $result = true;

                if (!$this->isDataNotEmpty($this->values['validator'], [
                    [
                        'key' => 'name',
                        'error' => 'validator_name',
                        'message_name' => 'Validator name',
                    ],
                ])) {
                    $result = false;
                }

                foreach ($this->values['validator']['validations'] as $key => $validation) {
                    $checkArray = [
                        [
                            'index' => $key,
                            'base_data' => 'validations',
                            'key' => 'name',
                            'error_in_data' => true,
                            'message_name' => 'Validation name',
                        ],
                        [
                            'index' => $key,
                            'base_data' => 'validations',
                            'key' => 'status_name',
                            'error_in_data' => true,
                            'message_name' => 'Status name',
                        ],
                        [
                            'index' => $key,
                            'base_data' => 'validations',
                            'key' => 'status_color',
                            'error_in_data' => true,
                            'message_name' => 'Status color',
                        ],
                    ];

                    if ($this->values['validator']['order']) {
                        array_push($checkArray, [
                            'index' => $key,
                            'base_data' => 'validations',
                            'key' => 'order',
                            'error_in_data' => true,
                            'message_name' => 'Validation order',
                        ]);
                    }

                    if (!$this->isDataNotEmpty($validation, $checkArray)) {
                        $result = false;
                    }
                }

                return $result;
                break;

            default:
                return true;
                break;
        }
    }

    private function setNumberinToBarcode()
    {
        foreach ($this->values['numbering'] as $key => $value) {
            if (isset($this->values['barcode'][$key]) && !in_array($key, ['form', 'elements'])) {
                $this->values['barcode'][$key] = $value;
            }
        }
    }

    private function isDataNotEmpty($data, $sources)
    {
        $result = true;

        foreach ($sources as $source) {
            if (empty($data[$source['key']]) && $data[$source['key']] != 0) {
                $result = false;
                $error = [
                    'show' => true,
                    'message' => $source['message_name'] . ' ' . __('is required!'),
                ];

                if (isset($source['error_in_data']) && $source['error_in_data']) {
                    if (isset($source['base_data'])) {
                        if ($source['base_data'] == 'tables') {
                            $this->tables[$source['index']]['errors'] = $error;
                        } else if ($source['base_data'] == 'fields') {
                            $this->tables[$source['index']]['fields'][$source['index2']]['errors'][$source['key']] = $error;
                        } else if ($source['base_data'] == 'forms') {
                            $this->values['template']['fields'][$source['index']]['errors'][$source['key']] = $error;
                        } else if ($source['base_data'] == 'validations') {
                            $this->values['validator']['validations'][$source['index']]['errors'][$source['key']] = $error;
                        } else {
                            $this->values[$source['base_data']][$source['index']]['errors'][$source['key']] = $error;
                        }
                    }
                } else {
                    $this->options['errors'][$source['error']] = $error;
                }
            } else {
                $emptyError = [
                    'show' => false,
                    'message' => '',
                ];

                if (isset($source['error_in_data']) && $source['error_in_data']) {
                    if (isset($source['base_data'])) {
                        if ($source['base_data'] == 'tables') {
                            $this->tables[$source['index']]['errors'] = $emptyError;
                        } else if ($source['base_data'] == 'fields') {
                            $this->tables[$source['index']]['fields'][$source['index2']]['errors'][$source['key']] = $emptyError;
                        } else if ($source['base_data'] == 'forms') {
                            $this->values['template']['fields'][$source['index']]['errors'][$source['key']] = $emptyError;
                        } else if ($source['base_data'] == 'validations') {
                            $this->values['validator']['validations'][$source['index']]['errors'][$source['key']] = $emptyError;
                        } else {
                            $this->values[$source['base_data']][$source['index']]['errors'][$source['key']] = $emptyError;
                        }
                    }
                } else {
                    $this->options['errors'][$source['error']] = $emptyError;
                }
            }
        }

        return $result;
    }

    private function isDataExists($data, $sources)
    {
        $result = false;

        foreach ($sources as $source) {
            $count = ModelHelper::getNewModel($source['table'], false)->where($source['db_key'], $data[$source['key']])->count();

            if ($count > 0) {
                $result = true;

                $this->options['errors'][$source['error']] = [
                    'show' => true,
                    'message' => $source['message_name'] . ' ' . __('is already exists!'),
                ];
            } else {
                $this->options['errors'][$source['error']] = [
                    'show' => false,
                    'message' => '',
                ];
            }
        }

        return $result;
    }

    private function getTableByKey($key)
    {
        return $this->tables[$key];
    }

    public function checkNameOfColumn($data, $sources)
    {
        $result = false;
        $usedColumns = ModelHelper::getUsedColumns();
        $error = [
            'show' => true,
            'message' => __('Cannot use column name!'),
        ];
        $emptyError = [
            'show' => false,
            'message' => '',
        ];

        foreach ($sources as $source) {
            if (in_array($data[$source['key']], $usedColumns)) {
                $result = true;

                if ($source['base_data'] == 'fields') {
                    $this->tables[$source['index']]['fields'][$source['index2']]['errors'][$source['key']] = $error;
                }
            } else {
                if ($source['base_data'] == 'fields') {
                    $this->tables[$source['index']]['fields'][$source['index2']]['errors'][$source['key']] = $emptyError;
                }
            }
        }

        return $result;
    }
}
