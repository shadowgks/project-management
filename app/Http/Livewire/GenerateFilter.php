<?php

namespace App\Http\Livewire;

use App\Helpers\ModelHelper;
use App\Helpers\StringHelper;
use App\Models\AppModule;
use App\Models\CustomFilter;
use App\Models\ProjectSetting;
use App\Traits\AppTrait;
use Auth;
use DB;
use Livewire\Component;
use DataTables;

class GenerateFilter extends Component
{
    use AppTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [
        'data' => [],
        'selected_columns' => [],
        'tables' => [],
        'columns' => [],
        'settings' => [],
        'settings-list' => [],
        'operations' => [],
        'filter_types' => [],
        'column_data_types' => [],
        'where_types' => [],
        'datatable' => [
            'name' => 'filters',
            'columns' => ['name', 'date', 'actions'],
            'data' => [],
            'route' => 'filters.list',
        ],
    ];

    public $values = [
        'name' => '',
        'setting_id' => '',
        'where' => [],
        'values_helper' => [],
        'columns_helper' => [],
    ];

    public $options = [
        'user' => null,
        'setting' => null,
        'values' => [],
        'selected_step' => 1,
        'modal_opened' => false,
        'show_modal' => false,
        'show_steps_modal' => false,
        'list_en_going' => false,
    ];

    public function render()
    {
        return view('livewire.generate-filter');
    }

    public function mount()
    {
        $user = Auth::user();

        if ($user != null) {
            $this->options['user'] = $user->toArray();
        }

        $this->base_data['filter_types'] = $this->getFilterTypes();
        $this->base_data['operations'] = ModelHelper::getOperations();
        $this->base_data['where_types'] = ModelHelper::getWhereTypes();
        $this->base_data['column_data_types'] = ModelHelper::getColumnsDataTypes();
        // $this->base_data['settings'] = ProjectSetting::where('type', ProjectSetting::RERPORT)->orderByDesc('id')->get()->toArray();
        // $this->base_data['settings'] = AppModule::select('pseudo_name AS id', 'name')->orderByDesc('name')->get()->toArray();
        $this->base_data['settings'] = AppModule::orderByDesc('name')->get(['pseudo_name AS vid', 'name'])->toArray();
    }

    public function get_setting()
    {
        $this->req(function () {
            $setting_id = $this->values['setting_id'];

            if ($setting_id == '') return;
            // $setting = ProjectSetting::where('id', $setting_id)->first()->toArray();
            // $values = @unserialize($setting['value']) ? unserialize($setting['value']) : [];
            // $this->options['setting'] = $setting;
            $this->options['values']['table'] = $setting_id;
            $this->options['values']['columns'] = ModelHelper::getColumnsOfTable($this->values['setting_id']);

            $this->base_data['tables'] = ModelHelper::getTables();
            // $this->base_data['columns'] = ModelHelper::getColumnsOfTable($values['table']);
            $this->base_data['columns'] = $this->options['values']['columns'];
        });
    }

    public function get_data()
    {
        $this->req(function () {
            $values = $this->options['values'];
            $table = $values['table'];
            $columns = $values['columns'];
            // $options = $values['options'];
            // $operations = $values['operations'];
            // $order_by = $values['order_by'];
            // $order_type = $values['order_type'];
            $where = $this->values['where'];
            $model = ModelHelper::getModelByTableName($table);
            // $joins = ModelHelper::getJoinTable($options, $table);
            $new_columns = array_map(function ($col) {
                return $col['name'];
            }, $columns);
            $columns_string = StringHelper::getColumnsStringForListing($new_columns);
            $data = $model->select(DB::raw($columns_string));

            // foreach ($joins as $join) {
            //     $data = $data->with($join);
            // }

            $data = ModelHelper::whereData($data, $where);

            // if (isset($order_by) and !empty($order_by))
            //     $data = $data->orderBy($order_by, $order_type);

            if (isset($group_by) and !empty($group_by))
                $data = $data->groupBy($group_by);

            $data = $data->get();

            $this->base_data['data'] = $data->toArray();
            // $this->base_data['selected_columns'] = $data->toArray();
            $this->base_data['selected_columns'] = ModelHelper::getColumnsShow($new_columns);
            $this->action_modal('hide', 'show_steps_modal');
        });
    }

    public function get_columns_of_table_join($key, $jkey = '')
    {
        $this->req(function () use ($key, $jkey) {
            if ($jkey != '')
                $table = $this->values['where'][$key]['joins']['tables'][$jkey]['value'];
            else
                $table = $this->values['where'][$key]['joins']['join_table'];

            $this->values['columns_helper'][$key] = ModelHelper::getColumnsOfTable($table);
        });
    }

    public function choose_column($key)
    {
        $this->req(function () use ($key) {
            $this->values['values_helper'][$key] = [];
            $where = $this->values['where'][$key];

            if ($where['type'] == 1) {
                if ($where['column']['value'] == '') return;

                $table = $this->options['values']['table'];
                $column = $this->searchColumn($this->values['where'][$key]['column']['value']);
                $this->values['where'][$key]['column']['type'] = $column['type'];
                $column_selected = $this->values['where'][$key]['column'];
            } else {
                if ($where['joins']['value'] == '') return;

                $joins_table_length = count($where['joins']['tables']);
                if ($joins_table_length > 0)
                    $table = $where['joins']['tables'][$joins_table_length - 1]['value'];
                else
                    $table = $where['joins']['join_table'];

                $column = $this->searchColumn($this->values['where'][$key]['joins']['value'], $this->values['columns_helper'][$key]);
                $this->values['where'][$key]['joins']['type'] = $column['type'];
                $column_selected = $this->values['where'][$key]['joins'];
            }

            if (($where['type'] == 1 and (!in_array($column_selected['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']) or str_contains($column_selected['value'], '_id'))) or ($where['type'] == 2 and !in_array($column_selected['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']))) {
                $model = ModelHelper::getModelByTableName($table);

                if ($where['type'] == 1) {
                    dd($column_selected['value'], $model, $table);
                    $this->values['values_helper'][$key] = $model->select($column_selected['value'] . ' as val')->distinct($column_selected['value'])->get()->toArray();
                } else {
                    $this->values['values_helper'][$key] = $model->select('id', $column_selected['value'] . ' as val')->distinct($column_selected['value'])->get()->toArray();
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
                    'tables' => [],
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
                    array_push($array_helper_2, $this->values['values_helper'][$key]);

                    if ($wh['type'] == 2) {
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

    public function append_join_table($key)
    {
        $this->req(function () use ($key) {
            array_push($this->values['where'][$key]['joins']['tables'], [
                'value' => '',
            ]);
        });
    }

    public function remove_join_table($id, $jid)
    {
        $this->req(function () use ($id, $jid) {
            $array_helper = [];

            foreach ($this->values['where'][$id]['joins']['tables'] as $key => $table) {
                if ($key != $jid) {
                    array_push($array_helper, $table);
                }
            }

            $this->values['values_helper'][$id] = [];
            $this->values['columns_helper'][$id] = [];
            $this->values['where'][$id]['joins']['tables'] = $array_helper;
        });
    }

    public function remove_all_join_table($key)
    {
        $this->req(function () use ($key) {
            $this->values['values_helper'][$key] = [];
            $this->values['columns_helper'][$key] = [];
            $this->values['where'][$key]['joins']['tables'] = [];
        });
    }

    // NOTE - ProjectSettings
    public function get_settings()
    {
        $data = CustomFilter::orderByDesc('id');
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

    public function save_settings()
    {
        $this->req(function () {
            try {
                DB::beginTransaction();
                $setting = new CustomFilter;
                $setting->name = $this->values['name'];
                $setting->value = serialize([
                    'setting_id' => $this->values['setting_id'],
                    'where' => $this->values['where'],
                    'user_id' => $this->options['user']['id'] ?? null,
                ]);
                $setting->user_id = $this->options['user']['id'] ?? null;
                $setting->setting_id = $this->values['setting_id'];
                $setting->save();
                DB::commit();

                $this->action_modal('hide');
                $this->showSlideAlert('success', 'Data saved successfully!');
                $this->cancel();
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
            $setting = CustomFilter::where('id', $id)->first();
            $setting_configs = (@unserialize($setting->value) ? unserialize($setting->value) : []);

            $this->values['name'] = $setting->name;
            $this->values['where'] = $setting_configs['where'];
            $this->values['setting_id'] = $setting_configs['setting_id'];
            $this->get_setting();

            foreach ($setting_configs['where'] as $key => $wh) {
                $this->get_columns_of_table_join($key);
                $this->choose_column($key);
            }

            $this->action_modal('show', 'show_steps_modal');
        });
    }

    public function delete_settings($id)
    {
        $this->req(function () use ($id) {
            try {
                DB::beginTransaction();
                CustomFilter::where('id', $id)->delete();
                DB::commit();

                $this->showSlideAlert('success', 'Data deleted successfully!');
                $this->reloadTable($this->base_data['datatable']['name']);
            } catch (\Exception $e) {
                $this->showAlert('error', $e->getMessage());
                DB::rollback();
            }
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

            if ($name_of_modal == 'show_steps_modal' && $action == 'show' && !$this->options['list_en_going'])
                $this->options['list_en_going'] = true;
        });
    }

    public function action_step($action)
    {
        $this->req(function () use ($action) {
            if ($action == 'next')
                $this->options['selected_step'] += 1;
            else
                $this->options['selected_step'] -= 1;
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
                    "column_total",
                    "selected_columns",
                ]))
                    $type = gettype($this->values[$key]);
                if ($type == 'string') {
                    $this->values[$key] = '';
                } else if ($type == 'array') {
                    $this->values[$key] = [];
                }
            }

            $this->base_data['data'] = [];
            $this->base_data['selected_columns'] = [];
            $this->options['modal_opened'] = false;
            $this->options['show_modal'] = false;
            $this->options['show_steps_modal'] = false;
            $this->options['selected_step'] = 1;
            $this->options['list_en_going'] = false;
            $this->action_modal('hide', 'show_steps_modal');
        });
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            $this->hideAlert();
        });
    }

    // NOTE - Tools
    private function searchColumn($name, $columns = null)
    {
        $result = null;

        if ($columns == null)
            $data = $this->base_data['columns'];
        else
            $data = $columns;

        foreach ($data as $column) {
            if ($column['id'] == $name) {
                $result = $column;
            }
        }

        return $result;
    }

    private function getFilterTypes()
    {
        return [
            [
                'id' => 1,
                'name' => 'Normal',
            ],
            [
                'id' => 2,
                'name' => 'Advanced',
            ],
        ];
    }
}
