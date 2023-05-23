<?php

namespace App\Http\Livewire;

use App\Helpers\FileHelper;
use App\Helpers\ModelHelper;
use App\Helpers\StringHelper;
use App\Models\ProjectSetting;
use App\Traits\AppTrait;
use App\Traits\Module\ListingTrait;
use Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class GenerateReport extends Component
{
    use AppTrait;
    use ListingTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [
        'data' => [],
        'totals' => [],
        'tables' => [],
        'columns' => [],
        'types' => [],
        'columns_show' => [],
        'settings' => [],
        'column_types' => [],
        'columns_options' => [],
        'columns_helper' => [],
        'columns_helper_2' => [],
        'filter_types' => [],
        'filter_date_types' => [],
        'column_data_types' => [],
        'where_types' => [],
        'operations' => [],
        'module' => [],
        'datatable' => [
            'name' => 'lists',
            'columns' => ['name', 'date', 'actions'],
            'data' => [],
            'route' => 'lists.list',
        ],
    ];

    public $values = [
        'module_id' => '',
        'name' => '',
        'name_table' => '',
        'table' => '',
        'column' => '',
        'selected_columns' => [],
        'selected_columns_show' => [],
        'order_by' => '',
        'order_type' => 'asc',
        'table_option' => '',
        'table_filter' => '',
        'column_option' => '',
        'column_option_helper' => '',
        'column_total' => false,
        'operation' => '',
        'operation_name' => '',
        'group_by' => '',
        'operations' => [],
        'options' => [],
        'totals' => [],
        'filters' => [],
        'where' => [],
        'types' => [],
        'custom_filters' => [],
        'values_helper' => [],
        'columns_helper' => [],
        'settings' => [
            'show_barcode' => false,
            'show_numbering' => false,
            'show_created_by' => true,
            'buttons' => [
                'edit' => false,
                'delete' => false,
                'print' => false,
                'validate' => false,
            ],
        ],
    ];

    public $options = [
        'title' => 'Orders Report',
        'show_actions' => [],
        'show_options' => false,
        'show_totals' => false,
        'use_filters' => false,
        'modal_opened' => false,
        'show_modal' => false,
        'show_steps_modal' => false,
        'list_en_going' => false,
        'selected_step' => 1,
        'id' => '',
        'target' => 'outside',
    ];

    public function render()
    {
        return view('livewire.generate-report');
    }

    // NOTE - Mount
    public function mount()
    {
        $settings = ProjectSetting::where('type', ProjectSetting::RERPORT)->orderByDesc('id')->get();

        $this->base_data['tables'] = ModelHelper::getTables();
        $this->base_data['settings'] = $settings;
        $this->base_data['column_types'] = $this->getColumnTypes();
        $this->base_data['filter_types'] = $this->getFilterTypes();
        $this->base_data['operations'] = ModelHelper::getOperations();
        $this->base_data['where_types'] = ModelHelper::getWhereTypes();
        $this->base_data['filter_date_types'] = $this->getFilterDateTypes();
        $this->base_data['column_data_types'] = ModelHelper::getColumnsDataTypes();
        $this->getListingSupportData();
    }

    // NOTE - ProjectSettings
    public function get_settings()
    {
        $data = ProjectSetting::where('type', ProjectSetting::RERPORT)->orderByDesc('id');
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
                    <a class="btn btn-primary btn-shadow btn-icon btn-sm me-1"
                        onclick="liveCall(\'show_data\', ' . $row['id'] . ')" wire:click="show_data(' . $row['id'] . ')">
                        <i class="la la-eye p-0"></i>
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

    public function save_settings()
    {
        $this->req(function () {
            try {
                DB::beginTransaction();
                $id = $this->listing['options']['id'];

                if ($id == '') {
                    $setting = new ProjectSetting;
                } else {
                    $setting = ProjectSetting::find($id);
                }

                $setting->type = ProjectSetting::RERPORT;
                $setting->name = $this->listing['values']['name'];
                $value_array = [
                    'title' => $this->listing['options']['title'],
                    'table' => $this->listing['values']['table'],
                    'columns' => $this->listing['values']['selected_columns'],
                    'selected_columns_show' => $this->listing['values']['selected_columns_show'],
                    'columns_show' => $this->listing['base_data']['columns_show'],
                    'order_by' => $this->listing['values']['order_by'] ?? '',
                    'order_type' => $this->listing['values']['order_type'] ?? '',
                    'group_by' => $this->listing['values']['group_by'] ?? '',
                    'operations' => $this->listing['values']['operations'],
                    'options' => $this->listing['values']['options'],
                    'totals' => $this->listing['values']['totals'],
                    'use_filters' => $this->listing['options']['use_filters'],
                    'filters' => $this->listing['values']['filters'],
                    'where' => $this->listing['values']['where'],
                    'types' => $this->listing['values']['types'],
                    'custom_filters' => $this->listing['values']['custom_filters'],
                    'name_table' => $this->listing['values']['name_table'],
                    'settings' => $this->listing['values']['settings'],
                ];

                if ($this->listing['values']['module_id'] != '') {
                    $value_array['module_id'] = $this->listing['values']['module_id'];
                }

                $setting->value = serialize($value_array);
                $setting->save();
                // $saved_id = $setting->id;
                DB::commit();

                if ($this->listing['values']['module_id'] != '') {
                    $module_name = ModelHelper::getModuleName($this->listing['values']['table']);
                    $path = 'Modules/' . $module_name . '/Http/Livewire/' . $module_name . '.php';
                    $file_content = $this->listing_generate_file(Auth::id(), $this->listing['values']['module_id']);
                    $this->change_content_of_controller($path, $file_content);
                }

                $this->listing_cancel();
                $this->action_modal('hide');
                $this->showSlideAlert('success', 'Data saved successfully!');
                $this->reloadTable($this->base_data['datatable']['name']);
            } catch (\Exception $e) {
                $this->showAlert('error', $e->getMessage());
                DB::rollback();
            }
        });
    }

    // NOTE - Show data
    public function show_data($id)
    {
        $this->req(function () use ($id) {
            $setting = ProjectSetting::where('id', $id)->first();
            $this->values['name'] = $setting->name;
            $setting_configs = (@unserialize($setting->value) ? unserialize($setting->value) : []);

            $table = $setting_configs['table'];
            $columns = $setting_configs['columns'];
            $order_by = $setting_configs['order_by'];
            $order_type = $setting_configs['order_type'];
            $group_by = $setting_configs['group_by'];
            $operations = $setting_configs['operations'];
            $options = $setting_configs['options'];
            $totals = $setting_configs['totals'];
            $joins = ModelHelper::getJoinTable($options, $table);
            $result = $this->generate_data($table, $columns, $joins, $totals, $order_type);
            $columns_show = ModelHelper::getColumnsShow($columns, $operations, $options);

            $this->listing['base_data']['columns_show'] = $columns_show;
            $this->listing['base_data']['data'] = $result['data']->toArray();
            $this->listing['base_data']['totals'] = $result['totals'];
        });
    }

    public function edit_settings($id)
    {
        $this->req(function () use ($id) {
            $setting = ProjectSetting::where('id', $id)->first();
            $setting_configs = (@unserialize($setting->value) ? unserialize($setting->value) : []);

            $this->listing['values']['module_id'] = $setting_configs['module_id'] ?? '';
            $this->listing['values']['name'] = $setting->name;
            $this->listing['options']['title'] = $setting_configs['title'];
            $this->listing['values']['table'] = $setting_configs['table'];
            $this->listing['values']['selected_columns'] = $setting_configs['columns'];
            $this->listing['values']['selected_columns_show'] = $setting_configs['columns_show'];
            $this->listing['base_data']['columns_show'] = $setting_configs['columns_show'];
            $this->listing['values']['order_by'] = $setting_configs['order_by'];
            $this->listing['values']['order_type'] = $setting_configs['order_type'];
            $this->listing['values']['group_by'] = $setting_configs['group_by'];
            $this->listing['values']['operations'] = $setting_configs['operations'];
            $this->listing['values']['options'] = $setting_configs['options'];
            $this->listing['values']['totals'] = $setting_configs['totals'];
            $this->listing['options']['use_filters'] = $setting_configs['use_filters'];
            $this->listing['values']['filters'] = $setting_configs['filters'];
            $this->listing['values']['where'] = $setting_configs['where'];
            $this->listing['values']['types'] = $setting_configs['types'];
            $this->listing['values']['custom_filters'] = $setting_configs['custom_filters'];
            $this->listing['values']['name_table'] = $setting_configs['name_table'];
            $this->listing['values']['settings'] = $setting_configs['settings'];
            $this->listing['options']['id'] = $id;
            $this->listing_get_columns();

            // dd($setting_configs);

            foreach ($setting_configs['where'] as $key => $wh) {
                $this->listing_choose_column($key);
                $this->listing_get_columns_of_table_join($key);
            }

            // dd($this->listing['base_data']['columns_helper']);

            foreach ($this->listing['values']['filters'] as $key => $column) {
                $this->listing_get_columns_of_table_filter($key);
            }

            foreach ($this->listing['values']['custom_filters'] as $key => $filter) {
                $this->listing_get_columns_of_advanced_table_filter($key);
            }

            $this->action_modal('show', 'show_steps_modal');
        });
    }

    public function delete_settings($id)
    {
        $this->req(function () use ($id) {
            try {
                DB::beginTransaction();
                ProjectSetting::where('id', $id)->delete();
                DB::commit();

                $this->showSlideAlert('success', 'Data deleted successfully!');
                $this->reloadTable($this->base_data['datatable']['name']);
            } catch (\Exception $e) {
                $this->showAlert('error', $e->getMessage());
                DB::rollback();
            }
        });
    }

    // NOTE - Functions
    public function get_columns()
    {
        $this->req(function () {
            $columns = Schema::getColumnListing($this->values['table']);
            $columns_helper = [];
            // dd($table->created_by()->getForeignKeyName());

            foreach ($columns as $column) {
                array_push($columns_helper, [
                    'id' => $column,
                    'name' => $column,
                    'type' => Schema::getColumnType($this->values['table'], $column),
                ]);
            }

            $this->base_data['columns'] = $columns_helper;
        });
    }

    public function get_data()
    {
        $this->req(function () {
            try {
                $this->values['selected_columns_show'] = [];
                foreach ($this->values['selected_columns'] as $column) {
                    array_push($this->values['selected_columns_show'], $column);
                }

                // if (this.values.operation_name != "")
                //   this.values.selected_columns_show.push(this.values.operation_name);

                foreach ($this->values['operations'] as $operation) {
                    array_push($this->values['selected_columns_show'], $operation['name']);
                }

                $table = $this->values['table'];
                $columns = $this->values['selected_columns'];
                $order_by = $this->values['order_by'];
                $order_type = $this->values['order_type'];
                $group_by = $this->values['group_by'];
                $operations = $this->values['operations'];
                $options = $this->values['options'];
                $totals = $this->values['totals'];
                $where = $this->values['where'];
                $types = $this->values['types'];
                // REVIEW - Join
                $joins = ModelHelper::getJoinTable($options, $table);
                $columns_string = ModelHelper::getColumnsString($columns, $operations, $options);
                // dd($columns, $columns_string, ModelHelper::getColumnsShow($columns, $operations, $options), $options);

                // $model = ModelHelper::getModelByTableName($table);
                $model_name = ModelHelper::getModelName($table);
                $model_string = '\Modules\\' . $model_name . 's' . '\\Entities\\' . $model_name;
                $model = new $model_string;

                if ($model == null) {
                    dd('Model is not defined! check project modules');
                    return;
                }

                $data = $model->select(DB::raw($columns_string));
                $totals_result = ModelHelper::getTotalsByModel($model, $totals, $columns);
                $columns_show = ModelHelper::getColumnsShow($columns, $operations, $options);

                foreach ($joins as $key => $join) {
                    // REVIEW - Disabled
                    // $data = $data->leftJoin(...$join);
                    $data = $data->with($join);
                }

                $data = ModelHelper::whereData($data, $where);

                if (isset($order_by) and !empty($order_by)) {
                    $data = $data->orderBy($order_by, $order_type);
                }

                if (isset($group_by) and !empty($group_by)) {
                    $data = $data->groupBy($group_by);
                }

                $data = $data->limit(10);

                $data = Datatables::of($data)
                    ->addIndexColumn();

                foreach ($columns_show as $column) {
                    if (str_contains($column, '.')) {
                        $data = $data->addColumn($column, function ($row) use ($column, $types) {
                            return StringHelper::printData($column, $row);
                        });
                    } else if (ModelHelper::isDateType($types[$column])) {
                        $data = $data->addColumn($column, function ($row) use ($column, $types) {
                            return StringHelper::printData($column, $row, $types[$column]);
                        });
                    }
                }

                $data = $data->rawColumns([])->make(true)->original['data'];

                // dd($data->original['data'], ModelHelper::getColumnsShow($columns, $operations, $options), $joins);

                // $data = $data->get();

                // dd(ModelHelper::getColumnsShow($columns, $operations, $options));
                // $this->base_data['data'] = $data->toArray();
                $this->base_data['data'] = $data;
                $this->base_data['totals'] = $totals_result;
                $this->base_data['types'] = $types;
                $this->base_data['columns_show'] = $columns_show;
                $this->action_modal('hide', 'show_steps_modal');
            } catch (\Exception $e) {
                $this->showAlert('error', $e->getMessage());
            }
        });
    }

    public function check_column($id, $type)
    {
        $this->req(function () use ($id, $type) {
            $array_helper = [];
            $exist = null;

            foreach ($this->values['selected_columns'] as $column) {
                if ($column == $id) {
                    $exist = $column;
                    $column_info = ModelHelper::getColumnInfos($this->base_data['columns'], $column);
                    if ($column_info != null) {
                        $this->values['types'][$id] = $column_info['type'];
                    }
                }
            }

            if ($exist == null) {
                foreach ($this->values['totals'] as $total) {
                    if (isset($total['name']) and $total['name'] != $id) {
                        array_push($array_helper, $total);
                    }
                }

                $this->values['totals'] = $array_helper;
                $array_helper = [];

                foreach ($this->values['options'] as $option) {
                    if (isset($option['old_name']) and $option['old_name'] != $id) {
                        array_push($array_helper, $option);
                    }
                }

                $this->values['options'] = $array_helper;
                $array_helper = [];

                foreach ($this->values['types'] as $key => $type) {
                    if ($key != $id) {
                        $array_helper[$key] = $type;
                    }
                }

                $this->values['types'] = $array_helper;
                $array_helper = [];

                if ($this->values['column_option_helper'] == $id) {
                    $this->values['column_total'] = false;
                    $this->options['show_totals'] = false;
                    $this->values['table_option'] = "";
                    $this->values['column_option'] = "";
                    $this->options['show_options'] = false;
                }
            }

            // Other
            // $this->base_data['columns_show'] = ModelHelper::getColumnsShow($columns);
            $this->actionFilters();
        });
    }

    public function choose_table_options()
    {
        $this->req(function () {
            if ($this->values['table_option'] == "") {
                return;
            }

            $this->base_data['columns_options'] = $this->get_columns_of_table($this->values['table_option']);
        });
    }

    public function choose_column($key)
    {
        $this->req(function () use ($key) {
            $this->values['values_helper'][$key] = [];
            $where = $this->values['where'][$key];

            if ($where['type'] == 1) {
                if ($where['column']['value'] == '') {
                    return;
                }

                $table = $this->values['table'];
                $column = $this->searchColumn($this->values['where'][$key]['column']['value']);
                $this->values['where'][$key]['column']['type'] = $column['type'];
                $column_selected = $this->values['where'][$key]['column'];
            } else {
                if ($where['joins']['value'] == '') {
                    return;
                }

                $table = $where['joins']['join_table'];
                $column = $this->searchColumn($this->values['where'][$key]['joins']['value'], $this->values['columns_helper'][$key]);
                $this->values['where'][$key]['joins']['type'] = $column['type'];
                $column_selected = $this->values['where'][$key]['joins'];
            }

            if (($where['type'] == 1 and (!in_array($column_selected['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']) or str_contains($column_selected['value'], '_id'))) or ($where['type'] == 2 and !in_array($column_selected['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']))) {
                $model = ModelHelper::getModelByTableName($table);

                if ($where['type'] == 1) {
                    $this->values['values_helper'][$key] = $model->select($column_selected['value'] . ' as val')->distinct($column_selected['value'])->get()->toArray();
                } else {
                    $this->values['values_helper'][$key] = $model->select('id', $column_selected['value'] . ' as val')->distinct($column_selected['value'])->get()->toArray();
                }
            }
        });
    }

    // NOTE - Columns
    public function append_column()
    {
        $this->req(function () {
            array_push($this->values['operations'], [
                'type' => 0,
                'name' => "",
                'value' => "",
                'order' => count($this->values['selected_columns']) + count($this->values['operations']),
            ]);
        });
    }

    public function remove_column($id)
    {
        $this->req(function () use ($id) {
            $array_helper = [];

            foreach ($this->values['operations'] as $key => $operation) {
                if ($key != $id) {
                    array_push($array_helper, $operation);
                }
            }

            $this->values['operations'] = $array_helper;
        });
    }

    // NOTE - Filters
    public function append_filter()
    {
        $this->req(function () {
            // dd($this->values['filters']);
            array_push($this->values['custom_filters'], [
                'type' => 1,
                'column' => '',
                'data_type' => '',
                'table' => '',
                'table_column' => '',
            ]);
        });
    }

    public function remove_filter($id)
    {
        $this->req(function () use ($id) {
            $array_helper = [];

            foreach ($this->values['custom_filters'] as $key => $operation) {
                if ($key != $id) {
                    array_push($array_helper, $operation);
                }
            }

            $this->values['custom_filters'] = $array_helper;
        });
    }

    public function append_where()
    {
        $this->req(function () {
            array_push($this->values['where'], [
                'type' => 1,
                'column' => [
                    'type' => '',
                    'value' => '',
                ],
                'operation' => '=',
                'data_type' => 'sum',
                'where_type' => 'and',
                'value' => '',
                'value_2' => '',
                'joins' => [
                    'join_table' => '',
                    'value' => '',
                    'type' => '',
                ],
            ]);
        });
    }

    public function remove_where($id)
    {
        $this->req(function () use ($id) {
            $array_helper = [];
            $array_helper_2 = [];
            $array_helper_3 = [];

            foreach ($this->values['where'] as $key => $wh) {
                if ($key != $id) {
                    array_push($array_helper, $wh);

                    if ($wh['type'] == 1) {
                        array_push($array_helper_2, $this->values['values_helper'][$key]);
                    } else if ($wh['type'] == 2) {
                        $new_index = count($array_helper) - 1;
                        $array_helper_3[$new_index] = $this->values['columns_helper'][$key];
                    }
                }
            }

            $this->values['where'] = $array_helper;
            $this->values['values_helper'] = $array_helper_2;
            $this->values['columns_helper'] = $array_helper_3;
        });
    }

    public function append_column_option()
    {
        $this->req(function () {
            $array_helper = [];
            $exist = false;

            if ($this->values['column_option'] == "") {
                foreach ($this->values['options'] as $option) {
                    if ($option['old_name'] != $this->values['column_option_helper']) {
                        array_push($array_helper, $option);
                    }
                }

                $this->values['options'] = $array_helper;
                return;
            }

            foreach ($this->values['options'] as $key => $option) {
                if ($option['old_name'] == $this->values['column_option_helper']) {
                    $array_helper[$key]['old_name'] = $this->values['column_option_helper'];
                    $array_helper[$key]['name'] = $this->values['column_option'];
                    $array_helper[$key]['table'] = $this->values['table_option'];
                    $exist = true;
                } else {
                    array_push($array_helper, $option);
                }
            }

            if (!$exist) {
                array_push($array_helper, [
                    'old_name' => $this->values['column_option_helper'],
                    'name' => $this->values['column_option'],
                    'table' => $this->values['table_option'],
                ]);
            }

            $this->values['options'] = $array_helper;
        });
    }

    public function append_column_total()
    {
        $this->req(function () {
            $array_helper = [];
            $total_finded = null;

            foreach ($this->values['totals'] as $total) {
                if ($total['name'] == $this->values['column_option_helper']) {
                    $total_finded = $total;
                }
            }

            if ($this->values['column_total']) {
                if ($total_finded == null) {
                    array_push($this->values['totals'], [
                        'name' => $this->values['column_option_helper'],
                    ]);
                }
            } else {
                if ($total_finded != null) {
                    foreach ($this->values['totals'] as $total) {
                        if ($total['name'] != $this->values['column_option_helper']) {
                            array_push($array_helper, $total);
                        }
                    }

                    $this->values['totals'] = $array_helper;
                }
            }
        });
    }

    public function init_filter_type($key)
    {
        $this->req(function () use ($key) {
            $this->values['columns_helper'][$key] = [];
        });
    }

    public function get_columns_of_table_join($key)
    {
        $this->req(function () use ($key) {
            $table = $this->values['where'][$key]['joins']['join_table'];

            if ($table != '') {
                $this->values['columns_helper'][$key] = ModelHelper::getColumnsOfTable($table);
            }
        });
    }

    public function get_columns_of_table_filter($id)
    {
        $this->req(function () use ($id) {
            $column_helper = $this->values['filters'][$id];

            if (isset($column_helper['data'])) {
                $this->base_data['columns_helper'][$column_helper['id']] = ModelHelper::getColumnsOfTable($column_helper['data']['table']);
            }
        });
    }

    public function get_columns_of_advanced_table_filter($id)
    {
        $this->req(function () use ($id) {
            $column_helper = $this->values['custom_filters'][$id];
            $this->base_data['columns_helper_2'] = ModelHelper::getColumnsOfTable($column_helper['table']);
        });
    }

    public function action_options($name)
    {
        $this->req(function () use ($name) {
            if ($name == $this->values['column_option_helper']) {
                return;
            }

            $this->options['show_options'] = str_contains($name, '_id');
            $this->values['column_option_helper'] = $name;
            $this->values['table_option'] = "";
            $this->values['column_option'] = "";

            $column_helper = null;
            foreach ($this->base_data['columns'] as $column) {
                if ($column['id'] == $name) {
                    $column_helper = $column;
                }
            }

            $option_finded = null;
            foreach ($this->values['options'] as $op) {
                if ($op['old_name'] == $name) {
                    $option_finded = $op;
                }
            }

            if ($option_finded != null) {
                $this->values['table_option'] = $option_finded['table'];
                $this->base_data['columns_options'] = $this->get_columns_of_table($this->values['table_option']);
                $this->values['column_option'] = $option_finded['name'];
            }

            if ($column_helper != null) {
                if (in_array($column_helper['type'], ["integer", "float", "double"]) and !$this->options['show_options']) {
                    $this->options['show_totals'] = true;

                    $total_finded = null;
                    foreach ($this->values['totals'] as $total) {
                        if ($total['name'] == $this->values['column_option_helper']) {
                            $total_finded = $total;
                        }
                    }

                    $this->values['column_total'] = ($total_finded != null);
                } else {
                    $this->options['show_totals'] = false;
                    $this->values['column_total'] = false;
                }
            }
        });
    }

    public function action_step($action)
    {
        $this->req(function () use ($action) {
            // dd($this->values['options']);
            if ($action == 'next') {
                $this->options['selected_step'] += 1;
            } else {
                $this->options['selected_step'] -= 1;
            }
        });
    }

    public function action_actions($key)
    {
        $this->req(function () use ($key) {
            $this->options['show_actions'][$key] = !$this->options['show_actions'][$key];
        });
    }

    public function save_modal()
    {
        // dd($this->listing);
        $this->req(function () {
            $this->action_modal('hide', 'show_steps_modal');
            $this->action_modal('show');
        });
    }

    public function cancel()
    {
        $this->req(function () {
            foreach ($this->values as $key => $value) {
                if (!in_array($key, [
                    "column_total",
                    "selected_columns",
                    "selected_columns_show",
                    "operations",
                    "options",
                    "totals",
                    "order_type",
                    "filters",
                    "where",
                    "columns_helper",
                    "custom_filters",
                    "values_helper",
                ])) {
                    $this->values[$key] = "";
                }
            }

            $this->values['order_type'] = "asc";
            $this->values['column_total'] = false;
            $this->values['operations'] = [];
            $this->values['options'] = [];
            $this->values['totals'] = [];
            $this->values['selected_columns'] = [];
            $this->values['selected_columns_show'] = [];
            $this->values['columns_helper'] = [];
            $this->values['custom_filters'] = [];
            $this->values['values_helper'] = [];
            $this->values['where'] = [];
            $this->values['filters'] = [];
            $this->base_data['columns_options'] = [];
            $this->base_data['columns'] = [];
            $this->base_data['columns_show'] = [];
            $this->base_data['data'] = [];
            $this->base_data['totals'] = [];
            $this->options['show_options'] = false;
            $this->options['show_totals'] = false;
            $this->options['modal_opened'] = false;
            $this->options['show_modal'] = false;
            $this->options['show_steps_modal'] = false;
            $this->options['selected_step'] = 1;
            $this->options['list_en_going'] = false;
        });
    }

    public function clear_preview()
    {
        $this->base_data['columns'] = [];
        $this->base_data['columns_show'] = [];
        $this->base_data['data'] = [];
        $this->base_data['totals'] = [];
        $this->values['selected_columns'] = [];
        $this->values['selected_columns_show'] = [];
    }

    // NOTE - Tools
    private function get_columns_of_table($table)
    {
        $columns = Schema::getColumnListing($table);
        $columns_helper = [];
        // dd($table->created_by()->getForeignKeyName());

        foreach ($columns as $column) {
            array_push($columns_helper, [
                'id' => $column,
                'name' => $column,
                'type' => Schema::getColumnType($table, $column),
            ]);
        }

        return $columns_helper;
    }

    private function getTotalsByModel($model, $totals, $columns)
    {
        $array_helper = [];

        if (count($totals) > 0) {
            foreach ($columns as $key => $column) {
                $not_exist = true;
                foreach ($totals as $total) {
                    $total = (object) $total;

                    if ($column == $total->name) {
                        array_push($array_helper, [
                            'order' => $key,
                            'value' => $model->sum($total->name),
                        ]);
                        $not_exist = false;
                    }
                }

                if ($not_exist) {
                    array_push($array_helper, [
                        'order' => null,
                        'value' => null,
                    ]);
                }
            }
        }

        return $array_helper;
    }

    private function searchColumn($name, $columns = null)
    {
        $result = null;

        if ($columns == null) {
            $data = $this->base_data['columns'];
        } else {
            $data = $columns;
        }

        foreach ($data as $column) {
            if ($column['id'] == $name) {
                $result = $column;
            }
        }

        return $result;
    }

    // NOTE - Action filters
    private function actionFilters()
    {
        $array_helper = [];
        $array_helper_2 = [];
        $array_filter_helper = [];
        $columns_helper = ModelHelper::getColumnsInfos($this->base_data['columns'], $this->values['selected_columns']);

        foreach ($columns_helper as $column) {
            $exist = null;

            foreach ($this->values['filters'] as $key => $filter) {
                if ($filter['id'] == $column['id']) {
                    $exist = $filter;
                    break;
                }
            }

            if ($exist == null) {
                $array_filter_helper = [
                    'id' => $column['id'],
                    'name' => $column['name'],
                    'type' => $column['type'],
                    'used' => false,
                ];

                if (ModelHelper::isDateType($column['type'])) {
                    $array_filter_helper['date'] = [
                        'type' => 1,
                        'from' => false,
                        'to' => false,
                        'equal' => false,
                        'day' => false,
                        'month' => false,
                        'year' => false,
                    ];
                } else {
                    $array_filter_helper['data'] = [
                        'table' => '',
                        'text' => '',
                    ];
                }

                array_push($array_helper, $array_filter_helper);
            } else {
                array_push($array_helper, $exist);
            }

            if (isset($this->base_data['columns_helper'][$column['id']])) {
                $array_helper_2[$column['id']] = $this->base_data['columns_helper'][$column['id']];
            } else {
                $array_helper_2[$column['id']] = [];
            }
        }

        $this->base_data['columns_helper'] = $array_helper_2;
        $this->values['filters'] = $array_helper;
    }

    private function getColumnsString($columns, $operations = [], $options = [])
    {
        $columns_string = '';
        $columns_length = count($columns);
        $operations_length = count($operations);
        $options_length = count($options);
        $option_exist_2 = false;

        foreach ($columns as $key => $column) {
            $columns_string .= ($key + 1 == $columns_length ? $column : $column . ', ');
        }

        if ($operations_length > 0) {
            $type_exist = false;

            foreach ($operations as $key => $operation) {
                $operation = (object) $operation;

                if ($operation->type == 4) {
                    if (!$type_exist and !$option_exist_2) {
                        $columns_string .= ', ';
                    }

                    $type_exist = true;
                    $columns_string .= ($key + 1 == $operations_length ? '(' . $operation->value . ') as value_' . $key : '(' . $operation->value . ') as value_' . $key . ', ');
                }
            }
        }

        return $columns_string;
    }

    private function getColumnsArray($columns, $operations = [], $options = [])
    {
        $columns_array = [];
        $operations_length = count($operations);
        $options_length = count($options);

        foreach ($columns as $column) {
            $option_exist = false;

            if ($options_length > 0) {
                foreach ($options as $key_2 => $option) {
                    $option = (object) $option;

                    if ($column == $option->old_name) {
                        $option_exist = true;
                        // $columns_array[$column] = $option->table . '.' . $option->name;
                        $columns_array[$column] = 'join_' . $key_2;
                        break;
                    }
                }

                if (!$option_exist) {
                    $columns_array[$column] = $column;
                }
            } else {
                $columns_array[$column] = $column;
            }
        }

        if ($operations_length > 0) {
            foreach ($operations as $key => $operation) {
                $operation = (object) $operation;
                // $columns_array[$operation->name] = $operation->name;
                $columns_array[$operation->name] = 'value_' . $key;
            }
        }

        return $columns_array;
    }

    private function getOrderOfColumn($columns, $column_search)
    {
        $result = null;
        foreach ($columns as $key => $column) {
            if ($column_search == $column) {
                $result = $key;
            }
        }

        return $result;
    }

    private function oneSimpleArrayKeyToString($array, $prefex, $object = true)
    {
        if ($object) {
            $string = '(object) [';
        } else {
            $string = '[';
        }

        foreach ($array as $key => $value) {
            $string .= '\'' . $value[$prefex] . '\'' . ' => ' . (gettype($value[$prefex]) == 'string' ? '\'' . $value[$prefex] . '\'' : ($value[$prefex] ?? 'null')) . ', ';
        }

        $string .= ']';
        return $string;
    }

    private function simpleArrayKeyToString($array, $object = true)
    {
        if ($object) {
            $string = '(object) [';
        } else {
            $string = '[';
        }

        foreach ($array as $key => $value) {
            $string .= '\'' . $key . '\'' . ' => ' . (gettype($value) == 'string' ? '\'' . $value . '\'' : ($value ?? 'null')) . ', ';
        }

        $string .= ']';
        return $string;
    }

    private function arrayKeyToString($array, $object = true)
    {
        $string = '[';

        foreach ($array as $arr) {
            if ($object) {
                $string .= '(object) [';
            } else {
                $string .= '[';
            }

            foreach ($arr as $key => $value) {
                $string .= '\'' . $key . '\'' . ' => ' . (gettype($value) == 'string' ? '\'' . $value . '\'' : ($value ?? 'null')) . ', ';
            }
            $string .= '], ';
        }

        $string .= ']';
        return $string;
    }

    private function generate_data($table, $columns, $joins, $totals, $order_type)
    {
        $model_pseudo = ModelHelper::getPseudoName($table);
        $model = ModelHelper::getModelByTableNameAndModule($table, $model_pseudo);
        $data = $model->select('*');
        $totals_result = $this->getTotalsByModel($model, $totals, $columns);

        foreach ($joins as $join) {
            $data = $data->with($join);
        }

        if (isset($order_by) and !empty($order_by)) {
            $data = $data->orderBy($order_by, $order_type);
        }

        if (isset($group_by) and !empty($group_by)) {
            $data = $data->groupBy($group_by);
        }

        $data = $data->limit(10)->get();
        return [
            'data' => $data,
            'totals' => $totals_result,
        ];
    }

    private function getColumnTypes()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'Text',
            ],
            (object) [
                'id' => 2,
                'name' => 'Checkbox',
            ],
            (object) [
                'id' => 3,
                'name' => 'Select',
            ],
            (object) [
                'id' => 4,
                'name' => 'Calculat',
            ],
        ];
    }

    private function getFilterTypes()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'Normal',
            ],
            (object) [
                'id' => 2,
                'name' => 'Advanced',
            ],
        ];
    }

    private function getFilterDateTypes()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'Standard',
            ],
            (object) [
                'id' => 2,
                'name' => 'Advanced',
            ],
        ];
    }

    private function getFilterDateValues()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'From the beginning',
            ],
            (object) [
                'id' => 2,
                'name' => 'This month',
            ],
            (object) [
                'id' => 3,
                'name' => 'Last month',
            ],
            (object) [
                'id' => 4,
                'name' => 'This year',
            ],
            (object) [
                'id' => 5,
                'name' => 'Last year',
            ],
            (object) [
                'id' => 6,
                'name' => 'Last 3 months',
            ],
            (object) [
                'id' => 7,
                'name' => 'Last 6 months',
            ],
            (object) [
                'id' => 8,
                'name' => 'Last 12 months',
            ],
            (object) [
                'id' => 9,
                'name' => 'Period',
            ],
        ];
    }

    public function alertResult($result)
    {
        $this->hideAlert();
    }

    private function showAlert($type, $content, $target = null, $buttonContent = null)
    {
        $this->options['alert']['show'] = true;
        $this->options['alert']['type'] = $type;
        $this->options['alert']['content'] = $content;

        if ($buttonContent == null) {
            $this->options['alert']['target'] = '';
        } else {
            $this->options['alert']['target'] = $target;
        }

        if ($buttonContent == null) {
            $this->options['alert']['button'] = '';
        } else {
            $this->options['alert']['button'] = $buttonContent;
        }
    }

    private function hideAlert()
    {
        $this->options['alert']['show'] = false;
    }

    // NOTE - Change content of controller
    private function change_content_of_controller($path, $content)
    {
        $controller_content = $content['controller'];
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['namespaces'], '// Listing namespaces - start', '// Listing namespaces - end');
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['variables']['base_data'], '// Listing base_data - start', '// Listing base_data - end');
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['variables']['filters'], '// Listing filters - start', '// Listing filters - end');
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['variables']['options'], '// Listing options - start', '// Listing options - end');
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['variables']['filterLoops'], '// Listing filterLoops - start', '// Listing filterLoops - end');
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['listeners'], '// Listing listeners - start', '// Listing listeners - end');
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['mount'], '// Listing mount - start', '// Listing mount - end');
        FileHelper::replaceMultipleLinesFileContent($path, $controller_content['methods'], '// Listing methods - start', '// Listing methods - end');
    }
}
