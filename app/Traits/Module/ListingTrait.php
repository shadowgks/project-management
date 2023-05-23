<?php

namespace App\Traits\Module;

use App\Helpers\DateHelper;
use App\Helpers\ModelHelper;
use App\Helpers\StringHelper;
use App\Models\ProjectSetting;
use DataTables;
use DB;
use Str;

trait ListingTrait
{
    public $listing = [
        'base_data' => [
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
        ],
        'values' => [
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
                'show_flagged' => false,
                'buttons' => [
                    'edit' => false,
                    'delete' => false,
                    'print' => false,
                    'validate' => false,
                ],
            ],
        ],
        'options' => [
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
            'table' => [],
            'checkbox' => false,
        ],
    ];

    public function action_modal($action, $name_of_modal = 'show_modal')
    {
        if ($action == 'show') {
            $this->listing['options'][$name_of_modal] = true;
            $this->listing['options']['modal_opened'] = true;
        } else {
            $this->listing['options'][$name_of_modal] = false;
            $this->listing['options']['modal_opened'] = false;
        }

        if (
            $name_of_modal == 'show_steps_modal' and !$this->listing['options']['list_en_going']
        ) {
            $this->listing['options']['list_en_going'] = true;
        }
    }

    public function getListingSupportData()
    {
        $this->listing['base_data']['tables'] = ModelHelper::getTables();
        $this->listing['base_data']['column_types'] = ModelHelper::getColumnTypes();
        $this->listing['base_data']['filter_types'] = ModelHelper::getFilterTypes();
        $this->listing['base_data']['operations'] = ModelHelper::getOperations();
        $this->listing['base_data']['where_types'] = ModelHelper::getWhereTypes();
        $this->listing['base_data']['filter_date_types'] = ModelHelper::getFilterDateTypes();
        $this->listing['base_data']['column_data_types'] = ModelHelper::getColumnsDataTypes();
    }

    public function listing_action_step($action)
    {
        if ($action == 'next') {
            $this->listing['options']['selected_step'] += 1;
        } else {
            $this->listing['options']['selected_step'] -= 1;
        }
    }

    private function listing_get_all_columns($table)
    {
        $columns = ModelHelper::getColumnsOfTable($table);
        // dd($table, $this->listing['base_data']['tables'], $table == 'accounts_charts');

        if (count($columns) <= 0) {
            $table = $this->listing_search_table($table);

            if (count($table) > 0) {
                foreach ($table['fields'] as $key => $column) {
                    array_push($columns, [
                        'id' => $column['field_name'],
                        'name' => $column['field_name'],
                        'type' => $column['field_type'],
                    ]);
                }
            }
        }

        return $columns;
    }

    public function listing_get_columns()
    {
        $table = $this->listing_search_table($this->listing['values']['table']);

        if (count($table) > 0) {
            $this->listing['options']['table'] = $this->listing_search_table($this->listing['values']['table']);
        }

        $this->listing['base_data']['columns'] = $this->listing_get_all_columns($this->listing['values']['table']);
    }

    private function listing_search_table($name)
    {
        if ($this->options['target'] == 'module') {
            foreach ($this->tables as $table) {
                if ($table['table_name'] == $name) {
                    return $table;
                }
            }
        } else {
            foreach ($this->listing['base_data']['tables'] as $table) {
                if ($table['name'] == $name) {
                    return $table;
                }
            }
        }

        return [];
    }

    public function listing_check_column($id, $type)
    {
        $array_helper = [];
        $exist = null;

        foreach ($this->listing['values']['selected_columns'] as $column) {
            if ($column == $id) {
                $exist = $column;
                $column_info = ModelHelper::getColumnInfos($this->listing['base_data']['columns'], $column);
                if ($column_info != null) {
                    $this->listing['values']['types'][$id] = $column_info['type'];
                }
            }
        }

        if ($exist == null) {
            foreach ($this->listing['values']['totals'] as $total) {
                if (isset($total['name']) and $total['name'] != $id) {
                    array_push($array_helper, $total);
                }
            }

            $this->listing['values']['totals'] = $array_helper;
            $array_helper = [];

            foreach ($this->listing['values']['options'] as $option) {
                if (isset($option['old_name']) and $option['old_name'] != $id) {
                    array_push($array_helper, $option);
                }
            }

            $this->listing['values']['options'] = $array_helper;
            $array_helper = [];

            foreach ($this->listing['values']['types'] as $key => $type) {
                if ($key != $id) {
                    $array_helper[$key] = $type;
                }
            }

            $this->listing['values']['types'] = $array_helper;
            $array_helper = [];

            if ($this->listing['values']['column_option_helper'] == $id) {
                $this->listing['values']['column_total'] = false;
                $this->listing['options']['show_totals'] = false;
                $this->listing['values']['table_option'] = "";
                $this->listing['values']['column_option'] = "";
                $this->listing['options']['show_options'] = false;
            }
        }

        $this->listing_actionFilters();
    }

    public function listing_action_options($name)
    {
        if ($name == $this->listing['values']['column_option_helper']) {
            return;
        }

        $this->listing['options']['show_options'] = str_contains($name, '_id');
        $this->listing['values']['column_option_helper'] = $name;
        $this->listing['values']['table_option'] = "";
        $this->listing['values']['column_option'] = "";

        $column_helper = null;
        foreach ($this->listing['base_data']['columns'] as $column) {
            if ($column['id'] == $name) {
                $column_helper = $column;
            }
        }

        $option_finded = null;
        foreach ($this->listing['values']['options'] as $op) {
            if ($op['old_name'] == $name) {
                $option_finded = $op;
            }
        }

        if ($option_finded != null) {
            $this->listing['values']['table_option'] = $option_finded['table'];
            $this->listing['base_data']['columns_options'] = ModelHelper::getColumnsOfTable($this->listing['values']['table_option']);
            $this->listing['values']['column_option'] = $option_finded['name'];
        }

        if ($column_helper != null) {
            if (in_array($column_helper['type'], ["integer", "float", "double"]) and !$this->listing['options']['show_options']) {
                $this->listing['options']['show_totals'] = true;

                $total_finded = null;
                foreach ($this->listing['values']['totals'] as $total) {
                    if ($total['name'] == $this->listing['values']['column_option_helper']) {
                        $total_finded = $total;
                    }
                }

                $this->listing['values']['column_total'] = ($total_finded != null);
            } else {
                $this->listing['options']['show_totals'] = false;
                $this->listing['values']['column_total'] = false;
            }
        }
    }

    public function listing_choose_table_options()
    {
        if ($this->listing['values']['table_option'] == "") {
            return;
        }

        $this->listing['base_data']['columns_options'] = $this->listing_get_all_columns($this->listing['values']['table_option']);
    }

    public function listing_append_column_total()
    {
        $array_helper = [];
        $total_finded = null;

        foreach ($this->listing['values']['totals'] as $total) {
            if ($total['name'] == $this->listing['values']['column_option_helper']) {
                $total_finded = $total;
            }
        }

        if ($this->listing['values']['column_total']) {
            if ($total_finded == null) {
                array_push($this->listing['values']['totals'], [
                    'name' => $this->listing['values']['column_option_helper'],
                ]);
            }
        } else {
            if ($total_finded != null) {
                foreach ($this->listing['values']['totals'] as $total) {
                    if ($total['name'] != $this->listing['values']['column_option_helper']) {
                        array_push($array_helper, $total);
                    }
                }

                $this->listing['values']['totals'] = $array_helper;
            }
        }
    }

    public function listing_append_column_option()
    {
        $array_helper = [];
        $exist = false;

        if ($this->listing['values']['column_option'] == "") {
            foreach ($this->listing['values']['options'] as $option) {
                if ($option['old_name'] != $this->listing['values']['column_option_helper']) {
                    array_push($array_helper, $option);
                }
            }

            $this->listing['values']['options'] = $array_helper;
            return;
        }

        foreach ($this->listing['values']['options'] as $key => $option) {
            if ($option['old_name'] == $this->listing['values']['column_option_helper']) {
                $array_helper[$key]['old_name'] = $this->listing['values']['column_option_helper'];
                $array_helper[$key]['name'] = $this->listing['values']['column_option'];
                $array_helper[$key]['table'] = $this->listing['values']['table_option'];
                $exist = true;
            } else {
                array_push($array_helper, $option);
            }
        }

        if (!$exist) {
            array_push($array_helper, [
                'old_name' => $this->listing['values']['column_option_helper'],
                'name' => $this->listing['values']['column_option'],
                'table' => $this->listing['values']['table_option'],
            ]);
        }

        $this->listing['values']['options'] = $array_helper;
    }

    public function listing_append_column()
    {
        array_push($this->listing['values']['operations'], [
            'type' => 0,
            'name' => "",
            'value' => "",
            'order' => count($this->listing['values']['selected_columns']) + count($this->listing['values']['operations']),
        ]);
    }

    public function listing_remove_column($id)
    {
        $array_helper = [];

        foreach ($this->listing['values']['operations'] as $key => $operation) {
            if ($key != $id) {
                array_push($array_helper, $operation);
            }
        }

        $this->listing['values']['operations'] = $array_helper;
    }

    public function listing_append_where()
    {
        array_push($this->listing['values']['where'], [
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
    }

    public function listing_remove_where($id)
    {
        $array_helper = [];
        $array_helper_2 = [];
        $array_helper_3 = [];

        foreach ($this->listing['values']['where'] as $key => $wh) {
            if ($key != $id) {
                array_push($array_helper, $wh);

                if ($wh['type'] == 1) {
                    array_push($array_helper_2, $this->listing['values']['values_helper'][$key]);
                } else if ($wh['type'] == 2) {
                    $new_index = count($array_helper) - 1;
                    $array_helper_3[$new_index] = $this->listing['values']['columns_helper'][$key];
                }
            }
        }

        $this->listing['values']['where'] = $array_helper;
        $this->listing['values']['values_helper'] = $array_helper_2;
        $this->listing['values']['columns_helper'] = $array_helper_3;
    }

    public function listing_append_filter()
    {
        array_push($this->listing['values']['custom_filters'], [
            'type' => 1,
            'column' => '',
            'data_type' => '',
            'table' => '',
            'table_column' => '',
        ]);
    }

    public function listing_remove_filter($id)
    {
        $array_helper = [];

        foreach ($this->listing['values']['custom_filters'] as $key => $operation) {
            if ($key != $id) {
                array_push($array_helper, $operation);
            }
        }

        $this->listing['values']['custom_filters'] = $array_helper;
    }

    public function listing_init_filter_type($key)
    {
        $this->listing['values']['columns_helper'][$key] = [];
    }

    public function listing_choose_column($key)
    {
        $this->listing['values']['values_helper'][$key] = [];
        $where = $this->listing['values']['where'][$key];

        if ($where['type'] == 1) {
            if ($where['column']['value'] == '') {
                return;
            }

            $table = $this->listing['values']['table'];
            $column = $this->listing_searchColumn($this->listing['values']['where'][$key]['column']['value']);
            $this->listing['values']['where'][$key]['column']['type'] = $column['type'];
            $column_selected = $this->listing['values']['where'][$key]['column'];
        } else {
            if ($where['joins']['value'] == '') {
                return;
            }

            $table = $where['joins']['join_table'];
            $column = $this->listing_searchColumn($this->listing['values']['where'][$key]['joins']['value'], $this->listing['values']['columns_helper'][$key]);
            $this->listing['values']['where'][$key]['joins']['type'] = $column['type'];
            $column_selected = $this->listing['values']['where'][$key]['joins'];
        }

        if (($where['type'] == 1 and (!in_array($column_selected['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']) or str_contains($column_selected['value'], '_id'))) or ($where['type'] == 2 and !in_array($column_selected['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']))) {
            $model = ModelHelper::getModelByTableName($table);

            if ($where['type'] == 1) {
                $this->listing['values']['values_helper'][$key] = $model->select($column_selected['value'] . ' as val')->distinct($column_selected['value'])->get()->toArray();
            } else {
                $this->listing['values']['values_helper'][$key] = $model->select('id', $column_selected['value'] . ' as val')->distinct($column_selected['value'])->get()->toArray();
            }
        }
    }

    public function listing_get_columns_of_table_join($key)
    {
        $table = $this->listing['values']['where'][$key]['joins']['join_table'];

        if ($table != '') {
            $this->listing['values']['columns_helper'][$key] = $this->listing_get_all_columns($table);
        }
    }

    public function listing_get_columns_of_table_filter($id)
    {
        $column_helper = $this->listing['values']['filters'][$id];

        if (isset($column_helper['data'])) {
            $this->listing['base_data']['columns_helper'][$column_helper['id']] = $this->listing_get_all_columns($column_helper['data']['table']);
        }
    }

    public function listing_get_columns_of_advanced_table_filter($id)
    {
        $column_helper = $this->listing['values']['custom_filters'][$id];
        $this->listing['base_data']['columns_helper_2'] = $this->listing_get_all_columns($column_helper['table']);
    }

    public function listing_cancel()
    {
        foreach ($this->listing['values'] as $key => $value) {
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
                "types",
                "settings",
            ])) {
                $this->listing['values'][$key] = "";
            }
        }

        $this->listing['values']['order_type'] = "asc";
        $this->listing['values']['column_total'] = false;
        $this->listing['values']['operations'] = [];
        $this->listing['values']['options'] = [];
        $this->listing['values']['totals'] = [];
        $this->listing['values']['selected_columns'] = [];
        $this->listing['values']['selected_columns_show'] = [];
        $this->listing['values']['columns_helper'] = [];
        $this->listing['values']['custom_filters'] = [];
        $this->listing['values']['values_helper'] = [];
        $this->listing['values']['where'] = [];
        $this->listing['values']['filters'] = [];
        $this->listing['values']['types'] = [];

        // NOTE - Cancel listing settings
        $this->listing['values']['settings'] = [
            'show_barcode' => false,
            'show_numbering' => false,
            'show_created_by' => true,
            'show_flagged' => false,
            'buttons' => [
                'edit' => false,
                'delete' => false,
                'print' => false,
                'validate' => false,
            ],
        ];
        $this->listing['base_data']['columns_options'] = [];
        $this->listing['base_data']['columns'] = [];
        $this->listing['base_data']['columns_show'] = [];
        $this->listing['base_data']['data'] = [];
        $this->listing['base_data']['totals'] = [];
        $this->listing['options']['show_options'] = false;
        $this->listing['options']['show_totals'] = false;
        $this->listing['options']['modal_opened'] = false;
        $this->listing['options']['show_modal'] = false;
        $this->listing['options']['show_steps_modal'] = false;
        $this->listing['options']['selected_step'] = 1;
        $this->listing['options']['list_en_going'] = false;
        $this->listing['options']['table'] = [];
        $this->listing['options']['checkbox'] = false;

        if ($this->options['target'] == 'outside') {
            $this->cancel();
        }
    }

    // NOTE - Get data
    public function listing_get_data()
    {
        $this->listing['values']['selected_columns_show'] = [];
        foreach ($this->listing['values']['selected_columns'] as $column) {
            array_push($this->listing['values']['selected_columns_show'], $column);
        }

        // if (this.listing['values'].operation_name != "")
        //   this.listing['values'].selected_columns_show.push(this.listing['values'].operation_name);

        foreach ($this->listing['values']['operations'] as $operation) {
            array_push($this->listing['values']['selected_columns_show'], $operation['name']);
        }

        $table = $this->listing['values']['table'];
        $columns = $this->listing['values']['selected_columns'];
        $order_by = $this->listing['values']['order_by'];
        $order_type = $this->listing['values']['order_type'];
        $group_by = $this->listing['values']['group_by'];
        $operations = $this->listing['values']['operations'];
        $options = $this->listing['values']['options'];
        $totals = $this->listing['values']['totals'];
        $where = $this->listing['values']['where'];
        $types = $this->listing['values']['types'];
        // REVIEW - Join
        $joins = ModelHelper::getJoinTable($options, $table);
        $columns_string = ModelHelper::getColumnsString($columns, $operations, $options);

        $pseudo_name = ModelHelper::getPseudoName($table);
        $model = ModelHelper::getModelByTableName($pseudo_name);

        if ($model == null) {
            dd('Model is not defined! check project modules');
            return;
        }

        $data = $model->select(DB::raw($columns_string));
        $totals_result = ModelHelper::getTotalsByModel($model, $totals, $columns);
        $columns_show = ModelHelper::getColumnsShow($columns, $operations, $options);

        foreach ($joins as $join) {
            $data = $data->with($join);
        }

        $data = ModelHelper::whereData($data, $where);

        if (isset($order_by) and !empty($order_by)) {
            $data = $data->orderBy($order_by, $order_type);
        }

        if (isset($group_by) and !empty($group_by)) {
            $data = $data->groupBy($group_by);
        }

        $data = DataTables::of($data)
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
        // $data = $data->get();
        // $this->listing['base_data']['data'] = $data->toArray();
        $this->listing['base_data']['data'] = $data;
        $this->listing['base_data']['totals'] = $totals_result;
        $this->listing['base_data']['types'] = $types;
        $this->listing['base_data']['columns_show'] = $columns_show;
        // $this->listing_generate_file();

        if ($this->options['target'] == 'outside') {
            $this->action_modal('hide', 'show_steps_modal');
        }
    }

    public function listing_clear_preview()
    {
        $this->listing['base_data']['columns'] = [];
        $this->listing['base_data']['columns_show'] = [];
        $this->listing['base_data']['data'] = [];
        $this->listing['base_data']['totals'] = [];
        $this->listing['values']['selected_columns'] = [];
        $this->listing['values']['selected_columns_show'] = [];
    }

    private function listing_actionFilters()
    {
        $array_helper = [];
        $array_helper_2 = [];
        $array_filter_helper = [];
        $columns_helper = ModelHelper::getColumnsInfos($this->listing['base_data']['columns'], $this->listing['values']['selected_columns']);

        foreach ($columns_helper as $column) {
            $exist = null;

            foreach ($this->listing['values']['filters'] as $key => $filter) {
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

            if (isset($this->listing['base_data']['columns_helper'][$column['id']])) {
                $array_helper_2[$column['id']] = $this->listing['base_data']['columns_helper'][$column['id']];
            } else {
                $array_helper_2[$column['id']] = [];
            }
        }

        $this->listing['base_data']['columns_helper'] = $array_helper_2;
        $this->listing['values']['filters'] = $array_helper;
    }

    private function listing_searchColumn($name, $columns = null)
    {
        $result = null;

        if ($columns == null) {
            $data = $this->listing['base_data']['columns'];
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

    private function generateFiltersString($filters, $module)
    {
        $result = [
            'variables' => '',
            'base_data' => '',
            'filters' => '',
            'options' => '',
            'data' => '',
            'functions' => '',
            'loops' => '',
            'changes' => '',
        ];
        $variable_used = [
            'day' => false,
            'month' => false,
            'year' => false,
        ];

        if (count($filters) > 0) {
            $result['options'] .= '\'show_filters\' => false, \'selected_filter\' => -1,';
            $result['functions'] .= '
                public function action_options($name)
                {
                    $this->req(function () use ($name) {
                        $this->options[$name] = !$this->options[$name];
                    });
                }
            ';

            foreach ($filters as $filter) {
                if ($filter['used']) {
                    if (ModelHelper::isDateType($filter['type'])) {
                        $result['filters'] .= '\'' . $filter['name'] . '\' => \'\',';

                        if ($filter['date']['type'] == 1) {
                            $date_filters = DateHelper::getFilterDateValues();
                            $result['filters'] .= '\'' . $filter['name'] . '_period\' => 1, \'' . $filter['name'] . '_from\' => \'\', \'' . $filter['name'] . '_to\' => \'\',';
                            $result['variables'] .= '\'periods\' => [';

                            foreach ($date_filters as $df) {
                                $result['variables'] .= '[\'id\' => \'' . $df->id . '\', \'name\' => \'' . $df->name . '\'],';
                            }

                            $result['variables'] .= '],';

                            // NOTE - Period loops
                            $result['loops'] .= '[
                                "id" => "date-period",
                                "label" => "Period",
                                "model" => "filters.date_period",
                                "data" => "periods",
                                "value" => "id",
                                "text" => "name",
                            ],';

                            $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '($value)
                            {
                                $filters["' . $filter['name'] . '"] = $value;
                            }';

                            $result['data'] .= '$period_value = $filters[\'' . $filter['name'] . '_period\'];
                            if ($period_value != 1) {
                                $now = now();

                                if ($period_value == 2) {
                                    $data = $data->whereMonth(\'' . $filter['name'] . '\', $now->month);
                                } else if ($period_value == 3) {
                                    $data = $data->whereMonth(\'' . $filter['name'] . '\', $now->subMonth()->month);
                                } else if ($period_value == 4) {
                                    $data = $data->whereYear(\'' . $filter['name'] . '\', $now->year);
                                } else if ($period_value == 5) {
                                    $data = $data->whereYear(\'' . $filter['name'] . '\', $now->subYear()->year);
                                } else if ($period_value == 6) {
                                    $data = $data->whereDate(\'' . $filter['name'] . '\', \'>=\', $now->subMonth(2));
                                } else if ($period_value == 7) {
                                    $data = $data->whereDate(\'' . $filter['name'] . '\', \'>=\', $now->subMonth(5));
                                } else if ($period_value == 8) {
                                    $data = $data->whereDate(\'' . $filter['name'] . '\', \'>=\', $now->subMonth(11));
                                } else if ($period_value == 9) {
                                    if (!empty($filters[\'' . $filter['name'] . '_from\'])) {
                                        $data = $data->whereDate(\'' . $filter['name'] . '\', \'>=\', $filters[\'' . $filter['name'] . '_from\']);
                                    }

                                    if (!empty($filters[\'' . $filter['name'] . '_to\'])) {
                                        $data = $data->whereDate(\'' . $filter['name'] . '\', \'<=\', $filters[\'' . $filter['name'] . '_to\']);
                                    }
                                }
                            }';

                            // NOTE - Advanced period loops
                            $result['loops'] .= '[
                                "id" => "' . $filter['name'] . '-from",
                                "type" => "date",
                                "label" => "' . $filter['name'] . ' From",
                                "model" => "filters.' . $filter['name'] . '_from",
                                "condition" => [
                                    "where" => "' . $filter['name'] . '_period",
                                    "value" => 9,
                                ],
                            ],';

                            $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '_from($value)
                            {
                                $filters["' . $filter['name'] . '_from"] = $value;
                            }';

                            $result['loops'] .= '[
                                "id" => "' . $filter['name'] . '-to",
                                "type" => "date",
                                "label" => "' . $filter['name'] . ' To",
                                "model" => "filters.' . $filter['name'] . '_to",
                                "condition" => [
                                    "where" => "' . $filter['name'] . '_period",
                                    "value" => 9,
                                ],
                            ],';

                            $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '_to($value)
                            {
                                $filters["' . $filter['name'] . '_to"] = $value;
                            }';
                        } else {
                            if ($filter['date']['from']) {
                                $result['filters'] .= '\'' . $filter['name'] . '_from\' => \'\',';
                                $result['data'] .= 'if (!empty($filters[\'' . $filter['name'] . '_from\'])) {
                                $data = $data->whereDate(\'' . $filter['name'] . '\', \'>=\', $filters[\'' . $filter['name'] . '_from\']);
                            }';

                                // NOTE - Date from
                                $result['loops'] .= '[
                                    "id" => "' . $filter['name'] . '-from",
                                    "type" => "date",
                                    "label" => "' . $filter['name'] . ' From",
                                    "model" => "filters.' . $filter['name'] . '_from",
                                ],';

                                $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '_from($value)
                                {
                                    $filters["' . $filter['name'] . '_from"] = $value;
                                }';
                            }

                            if ($filter['date']['to']) {
                                $result['filters'] .= '\'' . $filter['name'] . '_to\' => \'\',';
                                $result['data'] .= 'if (!empty($filters[\'' . $filter['name'] . '_to\'])) {
                                $data = $data->whereDate(\'' . $filter['name'] . '\', \'<=\', $filters[\'' . $filter['name'] . '_to\']);
                            }';

                                // NOTE - Date to
                                $result['loops'] .= '[
                                    "id" => "' . $filter['name'] . '-to",
                                    "type" => "date",
                                    "label" => "' . $filter['name'] . ' To",
                                    "model" => "filters.' . $filter['name'] . '_to",
                                ],';

                                $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '_to($value)
                                {
                                    $filters["' . $filter['name'] . '_to"] = $value;
                                }';
                            }

                            if ($filter['date']['equal']) {
                                $result['filters'] .= '\'' . $filter['name'] . '\' => \'\',';
                                $result['data'] .= 'if (!empty($filters[\'' . $filter['name'] . '\'])) {
                                $data = $data->whereDate(\'' . $filter['name'] . '\', $filters[\'' . $filter['name'] . '\']);
                            }';

                                // NOTE - Date equal
                                $result['loops'] .= '[
                                    "id" => "' . $filter['name'] . '",
                                    "type" => "date",
                                    "label" => "' . $filter['name'] . '",
                                    "model" => "filters.' . $filter['name'] . '",
                                ],';

                                $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '($value)
                                {
                                    $filters["' . $filter['name'] . '"] = $value;
                                }';
                            }

                            if ($filter['date']['day']) {
                                if (!$variable_used['day']) {
                                    $result['variables'] .= '\'days\' => [],';
                                    $result['base_data'] .= '$this->base_data[\'days\'] = DateHelper::get_all_days_of_month();';
                                }
                                $result['filters'] .= '\'' . $filter['name'] . '_day\' => \'\',';
                                $result['data'] .= 'if (!empty($filters[\'' . $filter['name'] . '_day\'])) {
                                $data = $data->whereDay(\'' . $filter['name'] . '\', $filters[\'' . $filter['name'] . '_day\']);
                            }';

                                // NOTE - Date day
                                $result['loops'] .= '[
                                    "id" => "' . $filter['name'] . '-day",
                                    "label" => "Day (' . $filter['name'] . ')",
                                    "model" => "filters.' . $filter['name'] . '_day",
                                    "data" => "days",
                                ],';

                                $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '_day($value)
                                {
                                    $filters["' . $filter['name'] . '_day"] = $value;
                                }';
                            }

                            if ($filter['date']['month']) {
                                if (!$variable_used['month']) {
                                    $result['variables'] .= '\'months\' => [],';
                                    $result['base_data'] .= '$this->base_data[\'months\'] = DateHelper::get_months(false);';
                                }
                                $result['filters'] .= '\'' . $filter['name'] . '_month\' => \'\',';
                                $result['data'] .= 'if (!empty($filters[\'' . $filter['name'] . '_month\'])) {
                                $data = $data->whereMonth(\'' . $filter['name'] . '\', $filters[\'' . $filter['name'] . '_month\']);
                            }';

                                // NOTE - Date month
                                $result['loops'] .= '[
                                    "id" => "' . $filter['name'] . '-month",
                                    "label" => "Month (' . $filter['name'] . ')",
                                    "model" => "filters.' . $filter['name'] . '_month",
                                    "data" => "months",
                                    "value" => "id",
                                    "text" => "value",
                                ],';

                                $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '_month($value)
                                {
                                    $filters["' . $filter['name'] . '_month"] = $value;
                                }';
                            }

                            if ($filter['date']['year']) {
                                if (!$variable_used['year']) {
                                    $result['variables'] .= '\'years\' => [],';
                                    $result['base_data'] .= '$first_year = DateHelper::get_first_year($model, \'' . $filter['name'] . '\'); $this->base_data[\'years\'] = DateHelper::get_years($first_year);';
                                }
                                $result['filters'] .= '\'' . $filter['name'] . '_year\' => \'\',';
                                $result['data'] .= 'if (!empty($filters[\'' . $filter['name'] . '_year\'])) {
                                $data = $data->whereYear(\'' . $filter['name'] . '\', $filters[\'' . $filter['name'] . '_year\']);
                            }';

                                // NOTE - Date year
                                $result['loops'] .= '[
                                    "id" => "' . $filter['name'] . '-year",
                                    "label" => "Year (' . $filter['name'] . ')",
                                    "model" => "filters.' . $filter['name'] . '_year",
                                    "data" => "years",
                                ],';

                                $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '_year($value)
                                {
                                    $filters["' . $filter['name'] . '_year"] = $value;
                                }';
                            }
                        }
                    } else {
                        if (str_contains($filter['id'], '_id')) {
                            $pseudo_name = (in_array($filter['data']['table'], Modelhelper::default_modules) ? $filter['data']['table'] : Str::replace('_', '', Str::plural($filter['data']['table'])));
                            $model = ModelHelper::getModelStringByTableNameAndModule($filter['data']['table'], $pseudo_name);
                            if ($model == null) {
                                throw new \Exception('Model of table ' . $filter['data']['table'] . 'is not defined! check project modules');
                            }

                            if ($filter['data']['table'] == 'drop_downs')
                                $result['base_data'] .= '$this->base_data[\'' . $filter['name'] . '\'] = \\' . $model . '::where("select_field", "' . $filter['id'] . '")->orderBy(\'' . $filter['data']['text'] . '\')->get()->toArray();';
                            else
                                $result['base_data'] .= '$this->base_data[\'' . $filter['name'] . '\'] = \\' . $model . '::orderBy(\'' . $filter['data']['text'] . '\')->get()->toArray();';

                            // NOTE - Basic loops 1
                            $result['loops'] .= '[
                                "id" => "' . $filter['name'] . '",
                                "label" => "' . $filter['name'] . '",
                                "model" => "filters.' . $filter['name'] . '",
                                "data" => "' . $filter['name'] . '",
                                "value" => "id",
                                "text" => "' . $filter['data']['text'] . '",
                            ],';
                        } else {
                            $table = $this->listing['values']['table'];
                            $pseudo_name = (in_array($table, Modelhelper::default_modules) ? $table : Str::replace('_', '', Str::plural($table)));
                            $model = ModelHelper::getModelStringByTableNameAndModule($table, $pseudo_name);
                            if ($model == null) {
                                throw new \Exception('Model of table ' . $table . 'is not defined! check project modules');
                            }

                            if ($filter['data']['table'] == 'drop_downs')
                                $result['base_data'] .= '$this->base_data[\'' . $filter['name'] . '\'] = \\' . $model . '::where("select_field", "' . $filter['id'] . '")->orderBy(\'' . $filter['data']['text'] . '\')->get()->toArray();';
                            else
                                $result['base_data'] .= '$this->base_data[\'' . $filter['name'] . '\'] = \\' . $model . '::select(\'' . $filter['id'] . '\')->distinct(\'' . $filter['id'] . '\')->orderBy(\'' . $filter['id'] . '\')->get()->toArray();';

                            // NOTE - Basic loops 2
                            $result['loops'] .= '[
                                "id" => "' . $filter['name'] . '",
                                "label" => "' . $filter['name'] . '",
                                "model" => "filters.' . $filter['name'] . '",
                                "data" => "' . $filter['id'] . '",
                                "value" => "' . $filter['id'] . '",
                                "text" => "' . $filter['id'] . '",
                            ],';
                        }

                        $result['changes'] .= 'public function change_select_filters_' . $filter['name'] . '($value)
                        {
                            $filters["' . $filter['name'] . '"] = $value;
                        }';

                        $result['variables'] .= '\'' . $filter['name'] . '\' => [],';
                        $result['filters'] .= '\'' . $filter['name'] . '\' => \'\',';
                        $result['data'] .= 'if (!empty($filters[\'' . $filter['name'] . '\'])) {
                        $data = $data->where(\'' . $filter['name'] . '\', $filters[\'' . $filter['name'] . '\']);
                    }';
                    }
                }
            }
        }

        return $result;
    }

    private function generateWhereString($where)
    {
        $result = '';

        foreach ($where as $key => $wh) {
            if ($wh['type'] == 1) {
                if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double'])) {
                    if ($wh['operation'] == 'between') {
                        if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp'])) {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $result .= '$data = $data->orWhereDateBetween(\'' . $wh['column']['value'] . '\', [\'' . $wh['value'] . '\', \'' . $wh['value_2'] . '\']);';
                            } else {
                                $result .= '$data = $data->whereDateBetween(\'' . $wh['column']['value'] . '\', [\'' . $wh['value'] . '\', \'' . $wh['value_2'] . '\']);';
                            }
                        } else {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $result .= '$data = $data->orWhereBetween(\'' . $wh['column']['value'] . '\', [' . $wh['value'] . ', ' . $wh['value_2'] . ']);';
                            } else {
                                $result .= '$data = $data->whereBetween(\'' . $wh['column']['value'] . '\', [' . $wh['value'] . ', ' . $wh['value_2'] . ']);';
                            }
                        }
                    } else {
                        if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp'])) {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $result .= '$data = $data->orWhereDate(\'' . $wh['column']['value'] . '\', \'' . $wh['operation'] . '\', \'' . $wh['value'] . '\');';
                            } else {
                                $result .= '$data = $data->whereDate(\'' . $wh['column']['value'] . '\', \'' . $wh['operation'] . '\', \'' . $wh['value'] . '\');';
                            }
                        } else {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $result .= '$data = $data->orWhere(\'' . $wh['column']['value'] . '\', \'' . $wh['operation'] . '\', \'' . $wh['value'] . '\');';
                            } else {
                                $result .= '$data = $data->where(\'' . $wh['column']['value'] . '\', \'' . $wh['operation'] . '\', \'' . $wh['value'] . '\');';
                            }
                        }
                    }
                } else {
                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $result .= '$data = $data->orWhere(\'' . $wh['column']['value'] . '\', \'' . $wh['value'] . '\');';
                    } else {
                        $result .= '$data = $data->where(\'' . $wh['column']['value'] . '\', \'' . $wh['value'] . '\');';
                    }
                }
            } else {
                $joins = ModelHelper::getRelationName($wh['joins']['join_table'], 'many');

                if ($wh['operation'] == 'between') {
                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $result .= '$data->orWhereHas(\'' . $joins . '\', function ($query) {
            $query->havingRaw(\'' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') >= ' . $wh['value'] . ' and ' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') <= ' . $wh['value_2'] . '\');
        });';
                    } else {
                        $result .= '$data->whereHas(\'' . $joins . '\', function ($query) {
            $query->havingRaw(\'' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') >= ' . $wh['value'] . ' and ' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') <= ' . $wh['value_2'] . '\');
        });';
                    }
                } else {
                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $result .= '$data->orWhereHas(\'' . $joins . '\', function ($query) {
            $query->havingRaw(\'' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') ' . $wh['operation'] . ' ' . $wh['value'] . '\');
        });';
                    } else {
                        $result .= '$data->whereHas(\'' . $joins . '\', function ($query) {
            $query->havingRaw(\'' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') ' . $wh['operation'] . ' ' . $wh['value'] . '\');
        });
                    ';
                    }
                }
            }
        }

        return $result;
    }

    // NOTE - Generate file
    public function listing_generate_file($user_id = null, $module_id = null, $relations = null)
    {
        // $module = AppModule::where('id', $module_id)->first();
        $title = $this->listing['options']['title'];
        $name = $this->listing['values']['name_table'];
        $table = $this->listing['values']['table'];
        $columns = $this->listing['values']['selected_columns'];
        // $columns_show = $this->listing['base_data']['columns_show'];
        $order_by = $this->listing['values']['order_by'] ?? '';
        $order_type = $this->listing['values']['order_type'] ?? '';
        $group_by = $this->listing['values']['group_by'] ?? '';
        $operations = $this->listing['values']['operations'];
        $options = $this->listing['values']['options'];
        $totals = $this->listing['values']['totals'];
        $filters = $this->listing['values']['filters'];
        $where = $this->listing['values']['where'];
        $settings = $this->listing['values']['settings'];
        $joins = ModelHelper::getJoinTable($options, $table);
        $columns_show_result = ModelHelper::getColumnsShow($columns, $operations, $options, $settings);
        // $columns_string = StringHelper::getColumnsString($columns, $operations, $options, $settings);
        // $columns_string = StringHelper::getColumnsString($columns, [], [], $settings);
        // $columns_array = StringHelper::getColumnsArray($columns, $operations, $options);
        $columns_array_string = StringHelper::arrayToString($columns_show_result, $operations, $options, $settings);
        $model = ModelHelper::getModelStringByTableNameAndModule($table, (int) $module_id);
        $model_name = ModelHelper::getModelName($table);
        // $model_helper = ModelHelper::getModelByTableNameAndModule($table, (int) $module_id);
        // $totals_result = StringHelper::arrayKeyToString(ModelHelper::getTotalsByModel($model_helper, $totals, $columns));
        $totals_result = '[]';
        $operations_array = StringHelper::arrayKeyToString($operations);
        $string_totals = StringHelper::oneSimpleArrayKeyToString($totals, 'name', false);
        $filters_string = $this->generateFiltersString($filters, (int) $module_id);
        $where_string = $this->generateWhereString($where);
        $file_names = StringHelper::getFileNames($name);
        $module_pseudo_name = ModelHelper::getPseudoName($file_names['name']);
        $settings_string = StringHelper::getListingOptions($settings);

        if (count($joins) > 0) {
            $join_data_string = StringHelper::joinToString($joins, ['type' => 'eloquent']);
            $join_query_string = StringHelper::joinToString($joins, ['query_name' => 'queryBuilder', 'type' => 'eloquent']);
        } else {
            $join_data_string = '';
            $join_query_string = '';
        }

        $custom_filter_string = '';
        if ($user_id != null) {
            $custom_filter_string = '$this->base_data[\'custom_filters\'] = CustomFilter::where(\'setting_id\', ' . $user_id . ')->orderBy(\'name\')->get()->toArray();';
        }

        $controller_string = [
            'namespaces' => '
                // Listing namespaces - start
                // use ' . $model . ';
                // Listing namespaces - end
            ',
            'variables' => [
                'base_data' => '
                    // Listing base_data - start
                    "title" => "' . $file_names['name'] . '",
                    "module_name" => "' . $module_pseudo_name . '",
                    "data" => [],
                    "types" => ' . $columns_array_string . ',
                    "columns" => ' . $columns_array_string . ',
                    "operations" => ' . $operations_array . ',
                    "totals" => ' . $totals_result . ',
                    ' . $filters_string['variables'] . '
                    "custom_filters" => [],
                    // Listing base_data - end
                ',
                'filters' => '
                    // Listing filters - start
                    ' . $filters_string['filters'] . '
                    // Listing filters - end
                ',
                'options' => '
                    // Listing options - start
                    ' . $filters_string['options'] . '
                    \'show_modal\' => false,
                    \'show_form\' => false,
                    \'show_content\' => false,
                    \'id\' => null,
                    \'module_id\' => ' . $module_id . ',
                    // Listing options - end
                ',
                'filterLoops' => '
                    // Listing filterLoops - start
                    ' . $filters_string['loops'] . '
                    // Listing filterLoops - end
                ',
            ],
            'listeners' => '
                // Listing listeners - start
                "checkRow",
                "editData",
                "validateData",
                "printData",
                "deleteData",
                // Listing listeners - end
            ',
            'mount' => '
                // Listing mount - start
                ' . $filters_string['base_data'] . '
                ' . $custom_filter_string . '
                // Listing mount - end
            ',
            'methods' => '
                // Listing methods - start
                public function generateData()
                {
                    if (isset($this->options[\'selected_filter\'])) {
                        $this->options[\'selected_filter\'] = -1;
                    }

                    $filters = $_POST["d_filters"] ?? [];
                    $permissions = $this->getPermissions();
                    $model = new ' . $model_name . '();
                    $order_by = \'' . $order_by . '\';
                    $order_type = \'' . $order_type . '\';
                    $group_by = \'' . $group_by . '\';
                    $data = $model->select("*");
                    ' . $join_data_string . '

                    ' . $where_string . '

                    ' . $filters_string['data'] . '

                    $data = $data->with("created_by");

                    if (isset($order_by) and !empty($order_by))
                        $data = $data->orderBy($order_by, $order_type);

                    if (isset($group_by) and !empty($group_by))
                        $data = $data->groupBy($group_by);

                    $data = Datatables::of($data)->addIndexColumn();

                    foreach ($this->base_data[\'columns\'] as $column) {
                        if (str_contains($column, \'.\')) {
                            $data = $data->addColumn($column, function ($row) use ($column) {
                                return StringHelper::printData($column, $row);
                            });
                        }
                    }

                    ' . $settings_string . '

                    $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
                    return $data;
                }

                /* public function get_custom_filter_data($key)
                {
                    $this->req(function () use ($key) {
                        if (isset($this->options[\'selected_filter\'])) {
                            $this->options[\'selected_filter\'] = $key;
                        }

                        $permissions = $this->getPermissions();
                        $model = new ' . $model_name . '();
                        $order_by = \'date\';
                        $order_type = \'desc\';
                        $group_by = \'\';
                        $value = $this->base_data[\'custom_filters\'][$key][\'value\'];
                        $where = @unserialize($value) ? unserialize($value)[\'where\'] : [];
                        $data = $model->select("*");
                        $data = $data->with(\'customer\');
                        $data->with(\'branch\');

                        $data = ModelHelper::whereData($data, $where);

                        if (isset($order_by) and !empty($order_by))
                            $data = $data->orderBy($order_by, $order_type);

                        if (isset($group_by) and !empty($group_by))
                            $data = $data->groupBy($group_by);

                        $data = Datatables::of($data)->addIndexColumn();

                        foreach ($this->base_data[\'columns\'] as $column) {
                            if (str_contains($column, \'.\')) {
                                $data = $data->addColumn($column, function ($row) use ($column) {
                                    return StringHelper::printData($column, $row);
                                });
                            }
                        }

                        ' . $settings_string . '

                        $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
                        return $data;
                    });
                } */

                /* public function pdf()
                {
                    $order_by = \'' . $order_by . '\';
                    $order_type = \'' . $order_type . '\';
                    $group_by = \'' . $group_by . '\';
                    $columns_array = ' . $columns_array_string . ';
                    $totals = ' . $string_totals . ';
                    $meta = [ // For displaying filters description on header
                        \'Registered on\' => \'11/08/2022\',
                    ];

                    $model = new ' . $model_name . '();
                    $queryBuilder = $model::select($columns_array);

                    ' . $join_query_string . '

                    if (isset($order_by) and !empty($order_by))
                        $queryBuilder = $queryBuilder->orderBy($order_by, $order_type);

                    if (isset($group_by) and !empty($group_by))
                        $queryBuilder = $queryBuilder->groupBy($group_by);

                    $result = PdfReport::of(\'' . $title . '\', $meta, $queryBuilder, $columns_array);
                        // ->editColumn(\'date\', [ // Change column class or manipulate its data for displaying to report
                        //     \'displayAs\' => function ($result) {
                        //         return $result->created_at->format(\'d M Y\');
                        //     },
                        //     \'class\' => \'left\'
                        // ])

                    if (count($totals) > 0) {
                        $result = $result->showTotal($totals);
                    }

                    return $result->limit(20) // Limit record to be showed
                        // ->stream();
                        ->make()
                        ->download(\'' . $title . '\');
                } */

                /* public function excel(Request $request)
                {
                    $order_by = \'' . $order_by . '\';
                    $order_type = \'' . $order_type . '\';
                    $group_by = \'' . $group_by . '\';
                    $columns_array = ' . $columns_array_string . ';
                    $meta = [
                        \'Registered on\' => \'11/08/2022\',
                    ];

                    $model = new ' . $model_name . '();
                    $queryBuilder = $model::select($columns_array);

                    ' . $join_query_string . '

                    if (isset($order_by) and !empty($order_by))
                        $queryBuilder = $queryBuilder->orderBy($order_by, $order_type);

                    if (isset($group_by) and !empty($group_by))
                        $queryBuilder = $queryBuilder->groupBy($group_by);

                    return ExcelReport::of(\'' . $title . '\', $meta, $queryBuilder, $columns_array)
                        ->simple()
                        ->download(\'' . $title . '\');
                } */

                ' . $filters_string['functions'] . '

                ' . $filters_string['changes'] . '
                // Listing methods - end
            ',
            'filters_strings' => $filters_string,
        ];

        return [
            'controller' => $controller_string,
            'view' => '',
        ];
    }

    public function listing_save($module_id = null, $callback = null)
    {
        $setting = new ProjectSetting();
        $setting->type = ProjectSetting::RERPORT;
        $setting->name = $this->listing['values']['name_table'] . ' - listing';
        $setting->value = serialize([
            'module_id' => $module_id,
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
        ]);
        $setting->app_module_id = $module_id;
        $setting->save();

        if ($callback != null)
            $callback();
    }
}
