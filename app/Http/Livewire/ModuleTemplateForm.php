<?php

namespace App\Http\Livewire;

use App\Helpers\FileHelper;
use App\Helpers\ModelHelper;
use App\Models\AppModule;
use App\Models\DropDown;
use App\Models\Form;
use App\Traits\AppTrait;
use DB;
use Livewire\Component;
use DataTables;

class ModuleTemplateForm extends Component
{
    use AppTrait;

    public $base_data = [
        'tables' => [],
        'form' => [
            'form_types' => [],
            'files' => [],
            'modules' => [],
            'columns' => [],
            'value' => [
                'columns' => [],
            ],
        ],
        'settings' => [],
        'datatable' => [
            'name' => 'template-form',
            'columns' => ['name', 'date', 'actions'],
            'data' => [],
            'route' => 'template-form.list',
        ],
    ];

    public $values = [
        'name' => '',
        'file' => '',
        'module' => '',
        'template' => [
            'fields' => [],
        ],
        'path' => '',
        'controller' => '',
        'key' => '',
        'id' => '',
        'errors' => [
            'name' => [
                'show' => false,
                'message' => '',
            ],
        ],
    ];

    public $options = [
        'path' => '',
        'module' => [],
        'exception' => false,
    ];

    public $tables = [];

    public function render()
    {
        return view('livewire.outside.module-template-form');
    }

    public function mount()
    {
        $this->base_data['tables'] = ModelHelper::getTables();
        $this->tables = ModelHelper::getTables('table_name');
        $this->base_data['form']['modules'] = AppModule::orderByDesc('name')->get();
        $this->base_data['form']['form_types'] = ModelHelper::getFormTypes();
    }

    // NOTE - ProjectSettings
    public function get_settings()
    {
        $data = Form::orderByDesc('id');
        $data = Datatables::of($data)->addIndexColumn();

        $data = $data->addColumn('date', function ($row) {
            return '<span class="text-gray-800 fw-bold">' . _d($row['created_at']) . '</span>';
        })->addColumn('actions', function ($row) {
            return '
                <div class="text-end">
                    <a class="btn btn-secondary btn-shadow btn-icon btn-sm me-1"
                        onclick="liveCall(\'edit_settings\', ' . $row['id'] . ')" wire:click="edit_settings(' . $row['id'] . ')">
                        <i class="la la-pencil p-0"></i>
                    </a>
                    <a class="btn btn-danger btn-shadow btn-icon btn-sm"
                        data-kt-ecommerce-order-filter="delete_row"
                        onclick="liveCall(\'delete_settings\', ' . $row['id'] . ')" wire:click="delete_settings(' . $row['id'] . ')">
                        <i class="la la-trash p-0"></i>
                    </a>
                </div>
            ';
        });

        $data = $data->rawColumns(["date", "actions"])->make(true);
        return $data;
    }

    // NOTE - Save settings
    public function save_settings()
    {
        // dd($this->values);
        if (!$this->checkData()) return;
        // dd($this->values['template']['fields'], $this->options['module']['name'], $this->values['file']);

        try {
            DB::beginTransaction();
            $id = $this->values['id'];

            if ($id == '') {
                $setting = new Form;
                $setting->exception = false;
            } else {
                $setting = Form::find($id);
            }

            $setting->name = $this->values['name'];

            if (!$this->options['exception']) {
                $setting->app_module_id = $this->values['module'];
                $setting->path = $this->options['path'] . '/' . $this->values['file'];
            }

            DropDown::save_fields($this->values['template']['fields'], $this->options['module']['id']);

            $setting->value = serialize($this->values['template']['fields']);
            $setting->save();
            DB::commit();

            if ($this->options['exception']) {
                $this->changeFileContentException($this->values['template']['fields'], $this->values['path'], $this->values['controller'], $this->values['key']);
                $this->saveSeeders($setting, $this->options['module']['name'], $this->values['key']);
            } else {
                $this->changeFileContent($this->values['template']['fields'], $this->options['module']['name'], $this->values['file']);
            }
            $this->clear();
            $this->showSlideAlert('success', 'Form saved successfully!');
            $this->reloadTable($this->base_data['datatable']['name']);
        } catch (\Exception $e) {
            // dd($e);
            $this->showSlideAlert('error', getErrorMessage($e));
            DB::rollback();
        }
    }

    public function edit_settings($id)
    {
        try {
            $setting = Form::where('id', $id)->first();
            $setting_configs = (@unserialize($setting->value) ? unserialize($setting->value) : []);

            $this->options['module'] = AppModule::where('id', $setting->app_module_id)->first()->toArray();
            $this->values['id'] = $setting->id;
            $this->values['name'] = $setting->name;
            $this->values['template']['fields'] = $setting_configs;
            $this->values['path'] = $setting->path;
            $this->options['path'] = dirname($setting->path);
            $this->options['exception'] = $setting->exception;

            if ($this->options['exception']) {
                $this->values['controller'] = $setting->controller;
                $this->values['key'] = $setting->key;
            } else {
                $this->values['module'] = $setting->app_module_id;
                $this->values['file'] = basename($setting->path, '.blade.php');
                $this->get_files();
            }

            foreach ($this->values['template']['fields'] as $key => $field) {
                $this->getColumnsForField($key);
                if (in_array($field['type'], ['select', 'checkbox', 'radio']) && $field['value']['type'] == 'data') {
                    $this->getColumnsForValue($key);
                }
            }
        } catch (\Exception $e) {
            // dd($e);
            $this->showSlideAlert('error', getErrorMessage($e));
            DB::rollback();
        }
    }

    public function delete_settings($id)
    {
        try {
            DB::beginTransaction();
            Form::where('id', $id)->delete();
            DB::commit();

            $this->showSlideAlert('success', 'Form deleted successfully!');
            $this->reloadTable($this->base_data['datatable']['name']);
        } catch (\Exception $e) {
            $this->showSlideAlert('error', getErrorMessage($e));
            DB::rollback();
        }
    }

    public function get_files()
    {
        $this->req(function () {
            $this->base_data['form']['files'] = ModelHelper::getModuleFiles($this->options['module']['name'], 'resources/views');
        });
    }

    public function addFormField()
    {
        array_push($this->values['template']['fields'], [
            'active' => true,
            'order' => count($this->values['template']['fields']),
            'table' => '',
            'table_name' => '',
            'column' => '',
            'label' => '',
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

                if (count($this->base_data['form']['columns']) > 0) {
                    array_push($arrayHelper_2['columns'], $this->base_data['form']['columns'][$key]);
                }

                if (count($this->base_data['form']['value']['columns']) > 0) {
                    array_push($arrayHelper_2['value']['columns'], $this->base_data['form']['value']['columns'][$key]);
                }
            }
        }

        $this->values['template']['fields'] = $arrayHelper;
        $this->base_data['form']['columns'] = $arrayHelper_2['columns'];
        $this->base_data['form']['value']['columns'] = $arrayHelper_2['value']['columns'];

        if (count($arrayHelper) <= 0) {
            $this->values['errors'] = [
                'name' => [
                    'show' => false,
                    'message' => '',
                ],
            ];
        }
    }

    public function getColumnsForField($formFieldKey)
    {
        $field = $this->values['template']['fields'][$formFieldKey];
        $table = $this->tables[$field['table']]['id'];
        $this->values['template']['fields'][$formFieldKey]['table_name'] = $table;
        $columns = ModelHelper::getColumnsOfTable($table);
        $exist = (count($this->base_data['form']['columns']) - 1 >= $formFieldKey);

        if ($exist) {
            $this->base_data['form']['columns'][$formFieldKey] = $columns;
        } else {
            array_push($this->base_data['form']['columns'], $columns);
        }
    }

    public function getColumnsForValue($formFieldKey)
    {
        $field = $this->values['template']['fields'][$formFieldKey];
        $table = $field['value']['table'];
        $columns = ModelHelper::getColumnsOfTable($table);
        $this->base_data['form']['value']['columns'][$formFieldKey] = $columns;
    }

    public function getColumnOptions($formFieldKey)
    {
        // $formField = $this->values['template']['fields'][$formFieldKey];
        // $table = $this->tables[$formField['table']];
        // $column = null;

        // foreach ($this->base_data['form']['columns'][$formFieldKey] as $field) {
        //     if ($field['id'] == $formField['column'])
        //         $column = $field;
        // };

        // if (ModelHelper::isStringType($column['type'])) {
        //     $this->values['template']['fields'][$formFieldKey]['length'] = (int) $column['field_length'];
        // } else {
        //     $this->values['template']['fields'][$formFieldKey]['length'] = 0;
        // }

        // if (!$column['field_nullable']) {
        //     $this->values['template']['fields'][$formFieldKey]['required'] = true;
        //     $this->values['template']['fields'][$formFieldKey]['options']['show_required'] = false;
        // } else {
        //     $this->values['template']['fields'][$formFieldKey]['required'] = false;
        //     $this->values['template']['fields'][$formFieldKey]['options']['show_required'] = true;
        // }
        // $field = $this->values['template']['fields'][$formFieldKey];
        // $table = $this->tables[$field['table']]['id'];
        // $formField = $this->values['template']['fields'][$formFieldKey];
        // $table = $this->tables[$formField['table']]['id'];
        // $column = null;

        // foreach ($table['fields'] as $field) {
        //     if ($field['field_name'] == $formField['column']) {
        //         $column = $field;
        //     }
        // };

        // if (ModelHelper::isStringType($column['field_type'])) {
        //     $this->values['template']['fields'][$formFieldKey]['length'] = (int) $column['field_length'];
        // } else {
        //     $this->values['template']['fields'][$formFieldKey]['length'] = 0;
        // }

        // if (!$column['field_nullable']) {
        //     $this->values['template']['fields'][$formFieldKey]['required'] = true;
        //     $this->values['template']['fields'][$formFieldKey]['options']['show_required'] = false;
        // } else {
        //     $this->values['template']['fields'][$formFieldKey]['required'] = false;
        //     $this->values['template']['fields'][$formFieldKey]['options']['show_required'] = true;
        // }

        // if ($column['field_unique']) {
        //     $this->values['template']['fields'][$formFieldKey]['unique'] = true;
        //     $this->values['template']['fields'][$formFieldKey]['options']['show_unique'] = false;
        // } else {
        //     $this->values['template']['fields'][$formFieldKey]['unique'] = false;
        //     $this->values['template']['fields'][$formFieldKey]['options']['show_unique'] = true;
        // }

        // if ($column['field_default']) {
        //     $this->values['template']['fields'][$formFieldKey]['default'] = $column['field_default_value'];
        // } else {
        //     $this->values['template']['fields'][$formFieldKey]['default'] = '';
        // }
    }

    public function checkFieldOrder($formFieldKey)
    {
        $field = $this->values['template']['fields'][$formFieldKey];

        foreach ($this->values['template']['fields'] as $key => $element) {
            if ($key != $formFieldKey && $element['order'] == $field['order']) {
                $this->values['template']['fields'][$key]['order'] = '';
                break;
            }
        }
    }

    public function addFormFieldCustomValue($formFieldKey)
    {
        array_push($this->values['template']['fields'][$formFieldKey]['value']['custom'], [
            'value' => '',
            'text' => '',
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

    public function clear()
    {
        $this->values = [
            'name' => '',
            'file' => '',
            'module' => '',
            'template' => [
                'fields' => [],
            ],
            'path' => '',
            'controller' => '',
            'key' => '',
            'id' => '',
            'errors' => [
                'name' => [
                    'show' => false,
                    'message' => '',
                ],
            ],
        ];

        $this->base_data['form']['columns'] = [];
        $this->base_data['form']['value'] = [
            'columns' => [],
        ];

        $this->options['path'] = '';
        $this->options['module'] = [];
        $this->options['exception'] = false;
    }

    // NOTE - Private functions
    private function checkData()
    {
        $result = true;

        if (!$this->isDataNotEmpty($this->values, [
            [
                'key' => 'name',
                'error' => 'name',
                'message_name' => 'Name',
            ],
        ])) $result = false;

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
            ])) $result = false;
        }

        return $result;
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
                        } else {
                            $this->values[$source['base_data']][$source['index']]['errors'][$source['key']] = $error;
                        }
                    }
                } else {
                    $this->values['errors'][$source['error']] = $error;
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
                        } else {
                            $this->values[$source['base_data']][$source['index']]['errors'][$source['key']] = $emptyError;
                        }
                    }
                } else {
                    $this->values['errors'][$source['error']] = $emptyError;
                }
            }
        }

        return $result;
    }

    // NOTE - Put fields to file
    private function changeFileContent($fields, $module, $file)
    {
        $fields_content = FileHelper::get_fields_view_content($fields);
        $controller_content = FileHelper::get_fields_controller_content($fields);

        $view_path = 'Modules/' . $module . '/Resources/views/livewire/' . $file . '.blade.php';
        $controller_path = 'Modules/' . $module . '/Http/Livewire/' . $module . '.php';

        FileHelper::replaceMultipleLinesViewWithKey($view_path, $fields_content, 'form');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_mount'], 'Form mount');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_values'], 'Form values');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_save_values'], 'Form save values');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_edit_values'], 'Form edit values');
    }

    private function changeFileContentException($fields, $view_path, $controller_path, $key)
    {
        $fields_content = FileHelper::get_fields_view_content($fields, 'file', null, $key);
        $controller_content = FileHelper::get_fields_controller_content($fields, $key);

        FileHelper::replaceMultipleLinesViewWithKey($view_path, $fields_content, $key . ' form');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_mount'], $key . ' Form mount');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_values'], $key . ' Form values');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_save_values'], $key . ' Form save values');
        FileHelper::replaceMultipleLinesFileWithKey($controller_path, $controller_content['form_edit_values'], $key . ' Form edit values');
    }

    private function saveSeeders($setting, $module, $key)
    {
        $path = 'Modules/' . $module . '/Database/Seeders/' . $module . 'DatabaseSeeder.php';
        $content = FileHelper::getFormSeedersContent($setting, $key);
        FileHelper::replaceMultipleLinesFileWithKey($path, $content, $key . ' Form seeders');
    }
}
