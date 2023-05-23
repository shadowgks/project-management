<?php

namespace App\Http\Livewire;

use App\Helpers\DateHelper;
use App\Helpers\ModelHelper;
use App\Helpers\StringHelper;
use App\Models\ProjectSetting;
use App\Traits\AppTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use DataTables;

class GenerateCharts extends Component
{
    use AppTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [
        'data' => [],
        'totals' => [],
        'types' => [],
        'data_types' => [],
        'tables' => [],
        'columns' => [],
        'settings' => [],
        'column_types' => [],
        'columns_options' => [],
        'columns_data_types' => [],
        'months' => [],
        'years' => [],
        'date_columns' => [],
        'filter_types' => [],
        'operations' => [],
        'datatable' => [
            'name' => 'charts',
            'columns' => ['name', 'date', 'actions'],
            'data' => [],
            'route' => 'charts.list',
        ],
    ];

    public $values = [
        'setting_name' => '',
        'name' => '',
        'name_chart' => '',
        'type' => 'line',
        'data_type' => 1,
        'data_label' => '',
        'table' => '',
        'column' => '',
        'column_data_type' => 'sum',
        'selected_columns' => [],
        'data_columns' => [],
        'where' => [],
        'date_column' => 'created_at',
    ];

    public $filters = [
        'month' => '',
        'year' => '',
    ];

    public $options = [
        'current_month' => '',
        'current_year' => '',
        'current_column' => '',
        'setting_id' => '',
        'values_helper' => [],
        'columns_helper' => [],
        'radio_column_type' => 1,
        'selected_step' => 1,
        'modal_opened' => false,
        'show_modal' => false,
        'show_steps_modal' => false,
        'list_en_going' => false,
    ];

    // Column data
    const STANDARD = 1;
    const ADNVANCED = 2;

    public function render()
    {
        return view('livewire.generate-charts');
    }

    public function boot()
    {
        $this->options['current_month'] = now()->month;
        $this->options['current_year'] = now()->year;
        $this->filters['month'] = $this->options['current_month'];
        $this->filters['year'] = $this->options['current_year'];
    }

    public function mount()
    {
        $settings = ProjectSetting::where('type', ProjectSetting::CHART)->orderByDesc('id')->get();
        $tables_helper = ModelHelper::getTables();

        $this->base_data['settings'] = $settings;
        $this->base_data['tables'] = $tables_helper;
        $this->base_data['types'] = $this->getChartTypes();
        $this->base_data['data_types'] = $this->getChartDataTypes();
        $this->base_data['columns_data_types'] = $this->getColumnsDataTypes();
        $this->base_data['months'] = DateHelper::get_months(false);
        $this->base_data['years'] = DateHelper::get_years(now()->year);
        $this->base_data['filter_types'] = $this->getFilterTypes();
        $this->base_data['operations'] = ModelHelper::getOperations();
    }

    // NOTE - ProjectSettings
    public function get_settings()
    {
        $data = ProjectSetting::where('type', ProjectSetting::CHART)->orderByDesc('id');
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
                $id = $this->options['setting_id'];

                if ($id == '') {
                    $setting = new ProjectSetting;
                } else {
                    $setting = ProjectSetting::find($id);
                }

                $setting->type = ProjectSetting::CHART;
                $setting->name = $this->values['setting_name'];
                $setting->value = serialize([
                    'name' => $this->values['name'],
                    'name_chart' => $this->values['name_chart'],
                    'type' => $this->values['type'],
                    'data_type' => $this->values['data_type'],
                    'data_label' => $this->values['data_label'],
                    'table' => $this->values['table'],
                    'date_column' => $this->values['date_column'],
                    'columns' => $this->values['selected_columns'],
                    'data_columns' => $this->values['data_columns'],
                    'column_data_type' => $this->values['column_data_type'],
                    'radio_column_type' => $this->options['radio_column_type'],
                ]);
                $setting->save();
                DB::commit();

                $this->generate_file();
                $this->options['setting_id'] = '';
                $this->cancel();
                $this->showSlideAlert('success', 'Data saved successfully!');
                $this->reloadTable($this->base_data['datatable']['name']);
            } catch (\Exception $e) {
                $this->showAlert('error', $e->getMessage());
                DB::rollback();
            }
        });
    }

    public function edit_settings($id)
    {
        $this->req(function () use ($id) {
            $setting = ProjectSetting::where('id', $id)->first();
            $setting_configs = (@unserialize($setting->value) ? unserialize($setting->value) : []);

            $this->values['setting_name'] = $setting->name;
            $this->values['name'] = $setting_configs['name'];
            $this->values['name_chart'] = $setting_configs['name_chart'];
            $this->values['type'] = $setting_configs['type'];
            $this->values['data_type'] = $setting_configs['data_type'];
            $this->values['data_label'] = $setting_configs['data_label'];
            $this->values['table'] = $setting_configs['table'];
            $this->values['date_column'] = $setting_configs['date_column'];
            $this->values['selected_columns'] = $setting_configs['columns'];
            $this->values['data_columns'] = $setting_configs['data_columns'];
            $this->values['column_data_type'] = $setting_configs['column_data_type'];
            $this->options['radio_column_type'] = $setting_configs['radio_column_type'];
            $this->options['setting_id'] = $id;
            $this->get_columns();
            $this->get_data();
        });
    }

    public function show_data($id)
    {
        $this->req(function () use ($id) {
            $setting = ProjectSetting::where('id', $id)->first();
            $setting_configs = (@unserialize($setting->value) ? unserialize($setting->value) : []);

            $setting_name = $setting->name;
            $name = $setting_configs['name'];
            $name_chart = $setting_configs['name_chart'];
            $type = $setting_configs['type'];
            $data_type = $setting_configs['data_type'];
            $data_label = $setting_configs['data_label'];
            $table = $setting_configs['table'];
            $columns = $setting_configs['columns'];
            $date_column = $setting_configs['date_column'];
            $data_columns = $setting_configs['data_columns'];
            $column_data_type = $setting_configs['column_data_type'];
            $radio_column_type = $setting_configs['radio_column_type'];

            $model = ModelHelper::getModelByTableName($table);
            $options_helper = $this->getColumnsOptions($column_data_type, $radio_column_type, $data_columns, $date_column);
            $generated_data = $this->generate_data($model, $columns, $data_type, $type, null, $options_helper);

            $this->dispatchBrowserEvent('contentChanged', [
                'name' => $name,
                'type' => $type,
                'labels' => $generated_data['labels'],
                'data' => $generated_data['data'],
            ]);
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
            $columns = ModelHelper::getColumnsOfTable($this->values['table']);
            $columns_helper = [];
            $date_helper = [];

            foreach ($columns as $column) {
                if (in_array($column['type'], ['integer', 'float', 'double']) and !str_contains($column['name'], '_id') and $column['name'] != 'id') {
                    array_push($columns_helper, $column);
                }

                if (in_array($column['type'], ['date', 'datetime', 'timestamp']) and $column['name'] != 'id') {
                    array_push($date_helper, $column);
                }
            }

            $this->base_data['columns'] = $columns_helper;
            $this->base_data['date_columns'] = $date_helper;
        });
    }

    public function get_data()
    {
        $this->req(function () {
            try {
                $name = $this->values['name_chart'];
                $type = $this->values['type'];
                $data_type = $this->values['data_type'];
                $table = $this->values['table'];
                $columns = $this->values['selected_columns'];
                $model = ModelHelper::getModelByTableName($table);
                $date_column = $this->values['date_column'];
                $data_columns = $this->values['data_columns'];
                $column_data_type = $this->values['column_data_type'];
                $radio_column_type = $this->options['radio_column_type'];
                $options_helper = $this->getColumnsOptions($column_data_type, $radio_column_type, $data_columns, $date_column);
                $generated_data = $this->generate_data($model, $columns, $data_type, $type, null, $options_helper);
                $this->action_modal('hide', 'show_steps_modal');

                $this->dispatchBrowserEvent('contentChanged', [
                    'name' => $name,
                    'type' => $type,
                    'labels' => $generated_data['labels'],
                    'data' => $generated_data['data'],
                ]);
            } catch (\Exception $e) {
                $this->showAlert('error', $e->getMessage());
            }
        });
    }

    public function filter_data()
    {
        $this->req(function () {
            try {
                $name = $this->values['name_chart'];
                $type = $this->values['type'];
                $data_type = $this->values['data_type'];
                $table = $this->values['table'];
                $columns = $this->values['selected_columns'];
                $filters = $this->filters;
                $model = ModelHelper::getModelByTableName($table);
                $date_column = $this->values['date_column'];
                $data_columns = $this->values['data_columns'];
                $column_data_type = $this->values['column_data_type'];
                $radio_column_type = $this->options['radio_column_type'];
                $options_helper = $this->getColumnsOptions($column_data_type, $radio_column_type, $data_columns, $date_column);
                $generated_data = $this->generate_data($model, $columns, $data_type, $type, $filters, $options_helper);

                $this->dispatchBrowserEvent('contentChanged', [
                    'name' => $name,
                    'type' => $type,
                    'labels' => $generated_data['labels'],
                    'data' => $generated_data['data'],
                ]);
            } catch (\Exception $e) {
                $this->showAlert('error', $e->getMessage());
            }
        });
    }

    public function action_data_column($type)
    {
        $this->req(function () use ($type) {
            $columns = $this->values['selected_columns'];
            $array_helper = [];

            if ($type == self::ADNVANCED) {
                foreach ($columns as $column) {
                    array_push($array_helper, [
                        'column' => $column,
                        'value' => 'sum',
                    ]);
                }
            }

            $this->values['data_columns'] = $array_helper;
        });
    }

    public function action_column($column)
    {
        $this->req(function () use ($column) {
            $this->options['current_column'] = $column;
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

                $joins_table_length = count($where['joins']['tables']);
                if ($joins_table_length > 0) {
                    $table = $where['joins']['tables'][$joins_table_length - 1]['value'];
                } else {
                    $table = $where['joins']['join_table'];
                }

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

    public function check_column()
    {
        $this->req(function () {
            $columns = $this->values['selected_columns'];
            $type = $this->options['radio_column_type'];
            $old_data_columns = $this->values['data_columns'];
            $array_helper = [];

            if ($type == self::ADNVANCED) {
                foreach ($columns as $column) {
                    $exist = false;

                    foreach ($old_data_columns as $key => $data_column) {
                        if ($column == $data_column['column']) {
                            array_push($array_helper, $data_column);
                            $exist = true;
                        }
                    }

                    if (!$exist) {
                        array_push($array_helper, [
                            'column' => $column,
                            'value' => 'sum',
                        ]);
                    }
                }
            }

            $this->values['data_columns'] = $array_helper;
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
                        array_push($array_helper_2, $this->options['values_helper'][$key]);
                    } else if ($wh['type'] == 2) {
                        $new_index = count($array_helper) - 1;
                        $array_helper_3[$new_index] = $this->options['columns_helper'][$key];
                    }
                }
            }

            $this->values['where'] = $array_helper;
            $this->options['values_helper'] = $array_helper_2;
            $this->options['columns_helper'] = $array_helper_3;
        });
    }

    public function action_modal($action, $name_of_modal = 'show_modal')
    {
        $this->req(function () use ($action, $name_of_modal) {
            if ($action == 'show') {
                $this->options[$name_of_modal] = true;
                $this->options['modal_opened'] = true;
            } else {
                $this->options[$name_of_modal] = false;
                $this->options['modal_opened'] = false;
            }

            if ($name_of_modal == 'show_steps_modal' && $action == 'show' && !$this->options['list_en_going']) {
                $this->options['list_en_going'] = true;
            }
        });
    }

    public function action_step($action)
    {
        $this->req(function () use ($action) {
            if ($action == 'next') {
                $this->options['selected_step'] += 1;
            } else {
                $this->options['selected_step'] -= 1;
            }
        });
    }

    public function save_modal()
    {
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
                    "type",
                    "data_type",
                    "selected_columns",
                    "date_column",
                    "data_columns",
                    "where",
                ])) {
                    $this->values[$key] = "";
                }
            }

            $this->values['type'] = 'line';
            $this->values['data_type'] = 1;
            $this->values['selected_columns'] = [];
            $this->values['date_column'] = 'created_at';
            $this->values['data_columns'] = [];
            $this->values['where'] = [];

            // foreach ($this->base_data as $key => $value) {
            //     if (!in_array($key, [
            //         "types",
            //         "data_types",
            //         "tables",
            //         "settings",
            //     ])) {
            //         $this->base_data[$key] = [];
            //     }
            // }

            $this->base_data['columns'] = [];

            foreach ($this->options as $key => $value) {
                if (!in_array($key, [
                    "radio_column_type",
                    "list_en_going",
                ])) {
                    $this->options[$key] = '';
                }
            }

            $this->options['radio_column_type'] = 1;
            $this->options['modal_opened'] = false;
            $this->options['show_modal'] = false;
            $this->options['show_steps_modal'] = false;
            $this->options['selected_step'] = 1;
            $this->options['list_en_going'] = false;
            $this->action_modal('hide', 'show_steps_modal');
            $this->dispatchBrowserEvent('contentReseted');
        });
    }

    // NOTE - Tools
    private function generate_data($model, $columns, $data_type, $type, $filters = null, $options = [])
    {
        $data_set = [];
        $date_column = $options['date'];
        $where = $this->values['where'];
        $columns_string = StringHelper::getColumnsString($columns, [], [], [
            'type' => $options['type'],
            'number' => 'price',
        ]);

        if (in_array($data_type, [2, 3, 4])) {
            $columns_helper = [];
            $data_helper = [];

            foreach ($columns as $column) {
                $data_helper[$column] = [];
            }

            if ($data_type == 2) {
                for ($day = 1; $day <= DateHelper::get_days_of_month(now()->month); $day++) {
                    $data = $model->select(DB::raw($columns_string))->whereDay($date_column, $day);
                    $data = ModelHelper::whereData($data, $where);

                    if ($filters != null) {
                        if (isset($filters['month']) and $filters['month'] != null) {
                            $data = $data->whereMonth($date_column, $filters['month']);
                        }

                        if (isset($filters['year']) and $filters['year'] != null) {
                            $data = $data->whereYear($date_column, $filters['year']);
                        }
                    }

                    $data = $data->groupBy('id');

                    foreach ($columns as $column) {
                        $data = $data->groupBy($column);
                    }

                    $data = $data->first();

                    if ($data != null) {
                        $data = $data->toArray();
                    }

                    foreach ($columns as $column) {
                        array_push($data_helper[$column], $data[$column] ?? 0);
                    }
                    array_push($columns_helper, $day);
                }
            } else if (in_array($data_type, [3, 4])) {
                $loop_data = [];

                if ($data_type == 3) {
                    $loop_data = DateHelper::get_months();
                } else if ($data_type == 4) {
                    $first_year = DateHelper::get_first_year($model);
                    $loop_data = DateHelper::get_years($first_year);
                }

                foreach ($loop_data as $lp_dt) {
                    $data = $model->select(DB::raw($columns_string));
                    $data = ModelHelper::whereData($data, $where);

                    if ($data_type == 3) {
                        $data = $data->whereMonth($date_column, $lp_dt->id);

                        if ($filters != null) {
                            if (isset($filters['year']) and $filters['year'] != null) {
                                $data = $data->whereYear($date_column, $filters['year']);
                            }
                        }
                    } else if ($data_type == 4) {
                        $data = $data->whereYear($date_column, $lp_dt);
                    }

                    $data = $data->groupBy('id');

                    foreach ($columns as $column) {
                        $data = $data->groupBy($column);
                    }

                    if ($data_type == 4) {
                        $data = $data->orderByDesc($date_column);
                    }

                    $data = $data->first();

                    if ($data != null) {
                        $data = $data->toArray();
                    }

                    foreach ($columns as $column) {
                        array_push($data_helper[$column], $data[$column] ?? 0);
                    }

                    if ($data_type == 3) {
                        array_push($columns_helper, $lp_dt->value);
                    } else if ($data_type == 4) {
                        array_push($columns_helper, $lp_dt);
                    }
                }
            }

            foreach ($columns as $column) {
                array_push($data_set, [
                    'name' => $column,
                    'data' => $data_helper[$column],
                ]);
            }
            $columns = $columns_helper;
        } else {
            $data_helper = [];
            $data = $model->select(DB::raw($columns_string));
            $data = ModelHelper::whereData($data, $where);

            if ($filters != null) {
                if (isset($filters['month']) and $filters['month'] != null) {
                    $data = $data->whereMonth($date_column, $filters['month']);
                }

                if (isset($filters['year']) and $filters['year'] != null) {
                    $data = $data->whereYear($date_column, $filters['year']);
                }
            }

            $data = $data->groupBy('id');

            foreach ($columns as $column) {
                $data = $data->groupBy($column);
            }

            $data = $data->first();

            if ($data != null) {
                $data = $data->toArray();

                foreach ($data as $key => $value) {
                    array_push($data_helper, $value);
                }
            }

            array_push($data_set, [
                'name' => $this->values['data_label'],
                'data' => $data_helper,
            ]);
        }

        if (in_array($type, ['pie', 'donut'])) {
            $data_set = $data_set[0]['data'];
        }

        return [
            'data' => $data_set,
            'labels' => $columns,
        ];
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

    private function getColumnsOptions($column_data_type, $radio_column_type, $data_columns, $date_column)
    {
        $options_helper = [];

        if ($radio_column_type == self::STANDARD) {
            $options_helper['type'] = $column_data_type;
        } else if ($radio_column_type == self::ADNVANCED) {
            $options_helper['type'] = $data_columns;
        }

        $options_helper['date'] = $date_column;
        return $options_helper;
    }

    private function getChartTypes()
    {
        return [
            [
                'id' => 'line',
                'name' => 'Line Chart',
            ],
            [
                'id' => 'bar',
                'name' => 'Bar Chart',
            ],
            [
                'id' => 'pie',
                'name' => 'Pie Chart',
            ],
            [
                'id' => 'donut',
                'name' => 'Donut Chart',
            ],
            [
                'id' => 'radar',
                'name' => 'Radar Chart',
            ],
            [
                'id' => 'area',
                'name' => 'Area Chart',
            ],
            [
                'id' => 'bubble',
                'name' => 'Bubble Chart',
            ],
        ];
    }

    private function getChartDataTypes()
    {
        return [
            [
                'id' => 1,
                'name' => 'Normal',
            ],
            [
                'id' => 2,
                'name' => 'Daily',
            ],
            [
                'id' => 3,
                'name' => 'Month',
            ],
            [
                'id' => 4,
                'name' => 'Year',
            ],
        ];
    }

    private function getColumnsDataTypes()
    {
        return [
            [
                'id' => 'sum',
                'name' => 'Sum',
            ],
            [
                'id' => 'count',
                'name' => 'Count',
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

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            $this->hideAlert();
        });
    }

    public function generate_file()
    {
        $this->req(function () {
            $name = $this->values['name_chart'];
            $type = $this->values['type'];
            $data_type = $this->values['data_type'];
            $data_label = $this->values['data_label'];
            $table = $this->values['table'];
            $columns = $this->values['selected_columns'];
            $date_column = $this->values['date_column'];
            $data_columns = $this->values['data_columns'];
            $column_data_type = $this->values['column_data_type'];
            $radio_column_type = $this->options['radio_column_type'];
            $options = $this->getColumnsOptions($column_data_type, $radio_column_type, $data_columns, $date_column);
            $columns_string = StringHelper::getColumnsString($columns, [], [], [
                'type' => $options['type'],
                'number' => 'price',
            ]);
            $columns_array_string = StringHelper::arrayToString($columns);
            $file_names = StringHelper::getFileNames($name);

            $model = ModelHelper::getModelStringByTableName($table);
            $model_name = ModelHelper::getModelName($table);
            $model_helper = ModelHelper::getModelByTableName($table);
            // $generated_data = $this->generate_data($model_helper, $columns, $data_type, $type);
            $data_set = [];

            $data_string = '';
            $label_string = '';

            if ($data_type == 2) {
                $data_string = 'for ($label = 1; $label <= DateHelper::get_days_of_month(now()->month); $label++) {
                    $data = $model->select(DB::raw(\'' . $columns_string . '\'))->whereDay(\'created_at\', $label);

                    if ($this->filters[\'month\'] != \'\') {
                        $data = $data->whereMonth(\'created_at\', $this->filters[\'month\']);
                    }

                    if ($this->filters[\'year\'] != \'\') {
                        $data = $data->whereYear(\'created_at\', $this->filters[\'year\']);
                    }

                    $data = $data->first()->toArray();';
                $label_string = '$label';
            } else if ($data_type == 3) {
                $data_string = 'foreach (DateHelper::get_months() as $label) {
                    $data = $model->select(DB::raw(\'' . $columns_string . '\'))->whereMonth(\'created_at\', $label->id);

                    if ($this->filters[\'year\'] != \'\') {
                        $data = $data->whereYear(\'created_at\', $this->filters[\'year\']);
                    }

                    $data = $data->first()->toArray();';
                $label_string = '$label->value';
            } else if ($data_type == 4) {
                $data_string = '$first_year = DateHelper::get_first_year($model);
                    foreach (DateHelper::get_years($first_year) as $label) {
                        $data = $model->select(DB::raw(\'' . $columns_string . '\'))->whereYear(\'created_at\', $label);

                        if ($this->filters[\'year\'] != \'\') {
                            $data = $data->whereYear(\'created_at\', $this->filters[\'year\']);
                        }

                        $data = $data->first()->toArray();';
                $label_string = '$label';
            } else {
                $data_string = '$data = $model->select(DB::raw(' . $columns_string . '))->first()->toArray();';
            }

            $operation_string = '';
            if ($data_type == 1) {
                $operation_string = '$data_helper = [];
                    $data = $model->select(DB::raw(\'' . $columns_string . '\'));

                    if ($this->filters[\'month\'] != \'\') {
                        $data = $data->whereMonth(\'created_at\', $this->filters[\'month\']);
                    }

                    if ($this->filters[\'year\'] != \'\') {
                        $data = $data->whereYear(\'created_at\', $this->filters[\'year\']);
                    }

                    $data = $data->first()->toArray();

                    foreach ($data as $key => $value) {
                        array_push($data_helper, $value);
                    }

                    array_push($data_set, [
                        \'name\' => \'' . $data_label . '\',
                        \'data\' => $data_helper,
                    ]);

                    $labels = $columns;';
            } else {
                $operation_string = 'foreach ($columns as $column) {
                    $data_helper[$column] = [];
                }

                ' . $data_string . '

                    foreach ($columns as $column) {
                        array_push($data_helper[$column], $data[$column] ?? 0);
                    }
                    array_push($columns_helper, ' . $label_string . ');
                }

                foreach ($columns as $column) {
                    array_push($data_set, [
                        \'name\' => $column,
                        \'data\' => $data_helper[$column],
                    ]);
                }

                $labels = $columns_helper;';
            }

            $standard_controller_string = '<?php
            namespace App\Http\Controllers;

            use App\Helpers\DateHelper;
            use Illuminate\Http\Request;
            use Illuminate\Support\Facades\DB;
            use ' . $model . ';

            class Standard' . $file_names['controller'] . ' extends Controller
            {
                public function index()
                {
                    $columns = ' . $columns_array_string . ';
                    $model = new ' . $model_name . '();

                    $columns_helper = [];
                    $data_helper = [];
                    $data_set = [];

                    ' . $operation_string . '

                    if (in_array(\'' . $type . '\', [\'pie\', \'donut\'])) {
                        $data_set = $data_set[0][\'data\'];
                    }

                    return view(\'Chart\')->with([
                        \'data\' => $data_set,
                        \'labels\' => $labels,
                    ]);
                }
            }';

            $advanced_controller_string = '<?php
            namespace App\Http\Livewire;

            use App\Helpers\DateHelper;
            use Illuminate\Support\Facades\DB;
            use Livewire\Component;
            use ' . $model . ';

            class ' . $file_names['controller'] . ' extends Component
            {
                // Data
                public $base_data = [
                    \'data\' => [],
                    \'labels\' => [],
                    \'months\' => [],
                    \'years\' => [],
                ];

                public $filters = [
                    \'month\' => \'\',
                    \'year\' => \'\',
                ];

                // Methods
                public function render()
                {
                    return view(\'livewire.Chart\');
                }

                public function mount()
                {
                    $this->generateData();
                    $this->base_data[\'months\'] = DateHelper::get_months(false);
                    $this->base_data[\'years\'] = DateHelper::get_years(now()->year);
                }

                public function getData() {
                    $this->generateData();

                    $this->dispatchBrowserEvent(\'contentChanged\', [
                        \'data\' => $this->base_data[\'data\'],
                        \'labels\' => $this->base_data[\'labels\'],
                    ]);
                }

                private function generateData()
                {
                    $columns = ' . $columns_array_string . ';
                    $model = new ' . $model_name . '();

                    $columns_helper = [];
                    $data_helper = [];
                    $data_set = [];

                    ' . $operation_string . '

                    if (in_array(\'' . $type . '\', [\'pie\', \'donut\'])) {
                        $data_set = $data_set[0][\'data\'];
                    }

                    $this->base_data[\'data\'] = $data_set;
                    $this->base_data[\'labels\'] = $labels;
                }

                public function boot()
                {
                    $now = now();
                    $this->filters[\'month\'] = $now->month;
                    $this->filters[\'year\'] = $now->year;
                }
            }';

            $chart_options = '';
            if (in_array($type, ['pie', 'donut'])) {
                $chart_options = 'labels: @json($labels),';
            } else {
                $chart_options = 'xaxis: {
                categories: @json($labels),
            }';
            }

            $advanced_chart_options = '';
            // $advanced_update_options = '';
            if (in_array($type, ['pie', 'donut'])) {
                $advanced_chart_options = 'labels: @json($base_data[\'labels\']),';
                // $advanced_chart_options = 'labels: [],';
                // $advanced_update_options = 'labels: data.labels,';
            } else {
                $advanced_chart_options = 'xaxis: {
                categories: @json($base_data[\'labels\']),
            }';
                // $advanced_chart_options = 'xaxis: {categories: [],}';
                // $advanced_update_options = 'xaxis: {categories: data.labels,},';
            }

            $filters_string = '';
            if (in_array($data_type, [1, 2])) {
                $filters_string .= '<div class="col-md-3">
                        <select name="months" class="form-select" id="months" wire:model="filters.month" wire:change="getData">
                            <option value="">All</option>
                            @foreach ($base_data[\'months\'] as $month)
                                <option value="{{ $month[\'id\'] }}" wire:key="month-{{ $month[\'id\'] }}">{{ $month[\'value\'] }}</option>
                            @endforeach
                        </select>
                    </div>
                ';
            }

            if (in_array($data_type, [1, 2, 3])) {
                $filters_string .= '
                    <div class="col-md-3">
                        <select name="years" class="form-select" id="years" wire:model="filters.year" wire:change="getData">
                            <option value="">All</option>
                            @foreach ($base_data[\'years\'] as $year)
                                <option value="{{ $year }}" wire:key="year-{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                ';
            }

            $standard_view_string = '@section(\'title\', \'' . $file_names['title'] . '\')
                <div class="row p-4">
                    <div id="chart"></div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                <script>
                    window.app_locale = "{{ config(\'app.locale\') }}";
                    window.base_url = "{{ URL::to(\'/\') }}";

                    var options = {
                        series: @json($data),
                        chart: {
                            height: 350,
                            type: "' . $type . '",
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: "straight"
                        },
                        title: {
                            text: "' . $name . '",
                            align: "left"
                        },
                        grid: {
                            row: {
                                colors: ["#f3f3f3", "transparent"],
                                opacity: 0.5
                            },
                        },
                        ' . $chart_options . '
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                </script>
            ';

            $advanced_view_string = '@section(\'title\', \'' . $file_names['title'] . '\')
                <div class="row p-4">
                    ' . $filters_string . '
                    <div id="chart"></div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                <script>
                    window.app_locale = "{{ config(\'app.locale\') }}";
                    window.base_url = "{{ URL::to(\'/\') }}";

                    var options = {
                        series: @json($base_data[\'data\']),
                        chart: {
                            height: 350,
                            type: "' . $type . '",
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: "straight"
                        },
                        title: {
                            text: "' . $name . '",
                            align: "left"
                        },
                        grid: {
                            row: {
                                colors: ["#f3f3f3", "transparent"],
                                opacity: 0.5
                            },
                        },
                        ' . $advanced_chart_options . '
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();

                    function update_chart(data) {
                        let new_options = {};

                        new_options = {
                            series: data.data,
                        };

                        chart.updateOptions(new_options);
                    }

                    document.addEventListener(\'contentChanged\', function(e) {
                        let data = e.detail;
                        update_chart(data);
                    });
                </script>
            ';

            Storage::put('Controllers/Standard' . $file_names['controller'] . '.php', $standard_controller_string);
            Storage::put('Controllers/' . $file_names['controller'] . '.php', $advanced_controller_string);
            Storage::put('resources/views/standard-' . $file_names['blade'] . '.blade.php', $standard_view_string);
            Storage::put('resources/views/' . $file_names['blade'] . '.blade.php', $advanced_view_string);
        });
    }
}
