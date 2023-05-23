<?php

namespace App\Helpers;

use App\Models\AppModule;
use Auth;
use DB;
use File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ModelHelper
{
    const default_modules = ['drop_downs'];

    public static function getTables($nameKey = 'name')
    {
        $result = [];
        $db_type = env('DB_CONNECTION');
        $db_name = DB::connection()->getDatabaseName();
        $column_name = 'Tables_in_' . $db_name;

        if ($db_type == 'pgsql') {
            $tables = DB::table('pg_catalog.pg_tables')->select('tablename')->where('schemaname', 'public')->get();
        } else {
            $tables = DB::select('show tables');
        }

        foreach ($tables as $table) {
            if ($db_type == 'pgsql') {
                array_push($result, [
                    'id' => $table->tablename,
                    $nameKey => $table->tablename,
                ]);
            } else {
                array_push($result, [
                    'id' => $table->$column_name,
                    $nameKey => $table->$column_name,
                ]);
            }
        }

        return $result;
    }

    public static function getModelByTableName($name)
    {

        $AppModule = AppModule::where('pseudo_name', $name)->first();
        if ($AppModule != null) {
            $model = $AppModule['namespace'] . '\\' . Str::studly(strtolower(Str::singular($name)));
            return new $model;
        } else {
            $model = 'App\Models\\' . Str::studly(strtolower(Str::singular($name)));
            return new $model;
            // return null;
        }
    }

    public static function getModelStringByTableName($name)
    {
        $AppModule = AppModule::where('pseudo_name', $name)->first();
        if ($AppModule != null) {
            $model = $AppModule['namespace'] . '\\' . Str::studly(strtolower(Str::singular($name)));
            return $model;
        } else {
            $model = 'App\Models\\' . Str::studly(strtolower(Str::singular($name)));
            return $model;
            // return null;
        }
    }

    public static function getModelByTableNameAndModule($name, $module = null)
    {
        if (in_array($name, self::default_modules)) {
            $model = 'App\Models\\' . Str::studly(strtolower(Str::singular($name)));
            return new $model;
        } else {
            if ($module == null) {
                $module = $name;
            }

            if (gettype($module) == 'integer')
                $AppModule = AppModule::where('id', $module)->first();
            else
                $AppModule = AppModule::where('pseudo_name', $module)->first();

            if ($AppModule != null) {
                $model = $AppModule['namespace'] . '\\' . Str::studly(strtolower(Str::singular($name)));
                return new $model;
            } else {
                return null;
            }
        }
    }

    public static function getModelStringByTableNameAndModule($name, $module = null)
    {
        if (in_array($name, self::default_modules)) {
            $model = 'App\Models\\' . Str::studly(strtolower(Str::singular($name)));
            return $model;
        } else {
            if ($module == null) {
                $module = $name;
            }

            if (gettype($module) == 'integer')
                $AppModule = AppModule::where('id', $module)->first();
            else
                $AppModule = AppModule::where('pseudo_name', $module)->first();

            if ($AppModule != null) {
                $model = $AppModule['namespace'] . '\\' . Str::studly(strtolower(Str::singular($name)));
                return $model;
            } else {
                return null;
            }
        }
    }

    public static function getNewModel($name, $check = true)
    {
        $model = ($check ? 'App\Models\\' . Str::studly(strtolower(Str::singular($name))) : 'App\Models\\' . $name);
        return new $model;
    }

    public static function getModelName($name)
    {
        $model = Str::studly(strtolower(Str::singular($name)));
        return $model;
    }

    public static function getModuleName($name)
    {
        $model = Str::studly(strtolower(Str::plural($name)));
        return $model;
    }

    public static function getRelationName($name, $type = 'one')
    {
        $model = str_replace('_id', '', strtolower(Str::singular($name)));

        if ($type == 'many') {
            $model .= 's';
        }

        return $model;
    }

    public static function getModuleModel($namespace, $name)
    {
        $name = Str::singular($name);
        return new ($namespace . '\\' . $name);
    }

    public static function getTableNameByModule($module_id)
    {
        $module = AppModule::find($module_id);
        $module_model = self::getModuleModel($module->namespace, $module->name);

        if ($module_model != null)
            return $module_model->getTable();
        else
            return null;
    }

    public static function getRelationsNames($basicName, $names)
    {
        $result = '';
        $result .= str_replace('_id', '', strtolower(Str::singular($basicName)));

        foreach ($names as $name) {
            $result .= '.';
            $result .= str_replace('_id', '', strtolower(Str::singular($name['value'])));
        }

        return $result;
    }

    // REVIEW - Join
    public static function getJoinTable($options, $table)
    {
        $result = [];
        $exist_tables = [];
        $options_length = count($options);

        foreach ($options as $key => $option) {
            $option = (object) $option;
            // dd(self::getRelationName($option->old_name));

            if (!in_array($option->table, $exist_tables)) {
                array_push($result, $option->table);
                array_push($exist_tables, $option->table);
            }
        }

        return $result;
    }

    public static function getColumnsOfTable($table)
    {
        $columns = Schema::getColumnListing($table);
        $columns_helper = [];

        foreach ($columns as $column) {
            try {
                $type = Schema::getColumnType($table, $column);
            } catch (\Exception $e) {
                $type = 'string';
            }

            array_push($columns_helper, [
                'id' => $column,
                'name' => $column,
                'type' => $type,
            ]);
        }

        return $columns_helper;
    }

    public static function getColumnsOfNewTable($table)
    {
        $columns = $table['fields'];
        $columns_helper = [];

        foreach ($columns as $column) {
            array_push($columns_helper, [
                'id' => $column['field_name'],
                'name' => $column['field_name'],
            ]);
        }

        return $columns_helper;
    }

    public static function getColumnsShow($columns, $operations = [], $options = [], $settings = [])
    {
        $result = [];
        $operations_length = count($operations);
        $options_length = count($options);

        if (count($settings) > 0) {
            if ($settings['show_numbering']) {
                array_push($result, 'reference');
            }

            if ($settings['show_barcode']) {
                array_push($result, 'barcode');
            }

            if ($settings['show_created_by']) {
                array_push($result, 'created_by_name');
            }
        }

        foreach ($columns as $key => $column) {
            $option_exist = false;

            if ($options_length > 0) {
                foreach ($options as $key_2 => $option) {
                    $option = (object) $option;

                    if ($column == $option->old_name) {
                        $option_exist = true;
                        array_push($result, $option->table . '.' . $option->name);
                        break;
                    }
                }

                if (!$option_exist) {
                    array_push($result, $column);
                }
            } else {
                array_push($result, $column);
            }
        }

        if ($operations_length > 0) {
            foreach ($operations as $key => $operation) {
                $operation = (object) $operation;

                if ($operation->type == 4) {
                    array_push($result, 'value_' . $key);
                }
            }
        }

        if (isset($settings['buttons']) && in_array(true, [$settings['buttons']['edit'], $settings['buttons']['delete'], $settings['buttons']['print'], $settings['buttons']['validate']])) {
            array_push($result, 'actions');
        }

        return $result;
    }

    public static function getColumnsInfos($columns, $selected_columns)
    {
        $array_helper = [];

        foreach ($columns as $column) {
            $search = array_search($column['id'], $selected_columns);

            if (is_numeric($search)) {
                array_push($array_helper, $column);
            }
        }

        return $array_helper;
    }

    public static function getColumnInfos($columns, $selected_column)
    {
        $result = null;

        foreach ($columns as $column) {
            if ($column['id'] == $selected_column) {
                $result = $column;
            }
        }

        return $result;
    }

    public static function getColumnsString($columns, $operations = [], $options = [])
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

    public static function getTotalsByModel($model, $totals, $columns)
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

    public static function whereData($data, $where)
    {
        foreach ($where as $key => $wh) {
            if ($wh['type'] == 1) {
                if (self::isNumberAndDateType($wh['column']['type'])) {
                    if ($wh['operation'] == 'between') {
                        if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp'])) {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhereDateBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            } else {
                                $data = $data->whereDateBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            }
                        } else {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhereBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            } else {
                                $data = $data->whereBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            }
                        }
                    } else {
                        if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp'])) {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhereDate($wh['column']['value'], $wh['operation'], $wh['value']);
                            } else {
                                $data = $data->whereDate($wh['column']['value'], $wh['operation'], $wh['value']);
                            }
                        } else {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhere($wh['column']['value'], $wh['operation'], $wh['value']);
                            } else {
                                $data = $data->where($wh['column']['value'], $wh['operation'], $wh['value']);
                            }
                        }
                    }
                } else {
                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $data = $data->orWhere($wh['column']['value'], $wh['value']);
                    } else {
                        $data = $data->where($wh['column']['value'], $wh['value']);
                    }
                }
            } else {
                if ($wh['data_type'] == 'normal') {
                    $joins = self::getRelationsNames($wh['joins']['join_table'], $wh['joins']['tables']);

                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $data = $data->orWhereHas($joins, function ($query) use ($wh) {
                            if (self::isNumberAndDateType($wh['column']['type'])) {
                                if ($wh['operation'] == 'between') {
                                    if (self::isDateType($wh['column']['type'])) {
                                        $query->whereDateBetween($wh['joins']['value'], [$wh['value'], $wh['value_2']]);
                                    } else {
                                        $query->whereBetween($wh['joins']['value'], [$wh['value'], $wh['value_2']]);
                                    }
                                } else {
                                    if (self::isDateType($wh['column']['type'])) {
                                        $query->whereDate($wh['joins']['value'], $wh['operation'], $wh['value']);
                                    } else {
                                        $query->where($wh['joins']['value'], $wh['operation'], $wh['value']);
                                    }
                                }
                            } else {
                                $query->where('id', $wh['value']);
                            }
                        });
                    } else {
                        $data = $data->whereHas($joins, function ($query) use ($wh) {
                            if (self::isNumberAndDateType($wh['column']['type'])) {
                                if ($wh['operation'] == 'between') {
                                    if (self::isDateType($wh['column']['type'])) {
                                        $query->whereDateBetween($wh['joins']['value'], [$wh['value'], $wh['value_2']]);
                                    } else {
                                        $query->whereBetween($wh['joins']['value'], [$wh['value'], $wh['value_2']]);
                                    }
                                } else {
                                    if (self::isDateType($wh['column']['type'])) {
                                        $query->whereDate($wh['joins']['value'], $wh['operation'], $wh['value']);
                                    } else {
                                        $query->where($wh['joins']['value'], $wh['operation'], $wh['value']);
                                    }
                                }
                            } else {
                                $query->where('id', $wh['value']);
                            }
                        });
                    }
                } else {
                    $joins = self::getRelationName($wh['joins']['join_table'], 'many');

                    if ($wh['operation'] == 'between') {
                        if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                            $data->orWhereHas($joins, function ($query) use ($wh) {
                                $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') >= ' . $wh['value'] . ' and ' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') <= ' . $wh['value_2']);
                            });
                        } else {
                            $data->whereHas($joins, function ($query) use ($wh) {
                                $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') >= ' . $wh['value'] . ' and ' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') <= ' . $wh['value_2']);
                            });
                        }
                    } else {
                        if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                            $data->orWhereHas($joins, function ($query) use ($wh) {
                                $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') ' . $wh['operation'] . ' ' . $wh['value']);
                            });
                        } else {
                            $data->whereHas($joins, function ($query) use ($wh) {
                                $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') ' . $wh['operation'] . ' ' . $wh['value']);
                            });
                        }
                    }
                }
            }
        }

        return $data;
    }

    public static function getPseudoName($name)
    {
        if (Str::singular($name) == $name)
            return Str::replace('_', '', Str::plural(Str::lower($name)));
        else
            return Str::replace('_', '', Str::lower($name));
    }

    public static function getRelationsString($tables)
    {
        $string = '';
        $exist = [];

        foreach ($tables as $table) {
            if ($table['field_seconday_key'] && !in_array($table['field_seconday_value'], $exist)) {
                $pseudo_name = self::getPseudoName($table['field_seconday_value']);
                $module = self::getModelStringByTableNameAndModule($table['field_seconday_value'], $pseudo_name);
                array_push($exist, $table['field_seconday_value']);
                $string .= '
                    public function ' . $table['field_seconday_value'] . '()
                    {
                        return $this->belongsTo(\\' . $module . '::class, "' . $table['field_name'] . '");
                    }
                ';
            }
        }

        return $string;
    }

    public static function getRelations($tables)
    {
        $array_helper = [];
        $exist = [];

        foreach ($tables as $table) {
            foreach ($table['fields'] as $field) {
                if ($field['field_seconday_key'] && !in_array($field['field_seconday_value'], $exist)) {
                    $pseudo_name = self::getPseudoName($field['field_seconday_value']);
                    $module = self::getModelStringByTableNameAndModule($field['field_seconday_value'], $pseudo_name);
                    array_push($exist, $field['field_seconday_value']);
                    array_push($array_helper, [
                        'module' => $module,
                        'pseudo_name' => $pseudo_name,
                        'relation' => $field['field_seconday_value'],
                        'foreign_key' => $field['field_name'],
                    ]);
                }
            }
        }

        return $array_helper;
    }

    public static function getBackupFiles()
    {
        $array_helper = [];
        $path = base_path('Modules/Backups');
        $files = File::allFiles($path);

        foreach ($files as $file) {
            array_push($array_helper, basename($file, '.txt'));
        }

        return $array_helper;
    }

    public static function getModuleFiles($module, $path_inside = '')
    {
        try {
            $array_helper = [];
            $path = base_path('Modules/' . $module . '/' . $path_inside);
            $files = File::allFiles($path);

            foreach ($files as $file) {
                $filename = explode('.', basename($file));
                array_push($array_helper, $filename[0]);
            }

            return $array_helper;
        } catch (\Exception $e) {
            throw new \Exception("Directory not exist!");
        }
    }

    public static function getModuleHelper($name)
    {
        // $model = 'Modules\Clients\Http\Helpers\\' . Str::studly(strtolower(Str::singular($name)));
        $model = 'Modules\Clients\Http\Helpers\\' . $name;
        return new $model;
    }

    public static function setModuleUpdate($module_name, $id, $bool = true, $callback = null)
    {
        $model = self::getModelByTableName($module_name);
        $on_update = $model::find($id);

        if ($bool) {
            $user = Auth::user();

            if ($on_update->on_update && $on_update->on_update_user_id != $user->id) {
                if ($callback != null)
                    $callback($user);
                return false;
            }

            $on_update->on_update = true;
            $on_update->on_update_user_id = Auth::id();
        } else {
            $on_update->on_update = false;
            $on_update->on_update_user_id = null;
        }

        $on_update->save();
        return true;
    }

    /**
     * @param string $type
     * @return boolean
     */
    public static function isDateType($type)
    {
        return in_array($type, ['date', 'time', 'datetime', 'timestamp']);
    }

    /**
     * @param string $type
     * @return boolean
     */
    public static function isNumberType($type)
    {
        return in_array($type, ['integer', 'float', 'double']);
    }

    /**
     * @param string $type
     * @return boolean
     */
    public static function inFloatType($type)
    {
        return in_array($type, ['float', 'decimal', 'double']);
    }

    /**
     * @param string $type
     * @return boolean
     */
    public static function isEnumType($type)
    {
        return in_array($type, ['enum']);
    }

    /**
     * @param string $type
     * @return boolean
     */
    public static function isNumberAndDateType($type)
    {
        return in_array($type, ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']);
    }

    /**
     * @param string $type
     * @return boolean
     */
    public static function isStringType($type)
    {
        return in_array($type, ['string', 'text', 'tinyText', 'mediumText', 'longText']);
    }

    public static function getColumnsDataTypes()
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

    public static function getWhereTypes()
    {
        return [
            [
                'id' => 'and',
                'name' => 'And',
            ],
            [
                'id' => 'or',
                'name' => 'Or',
            ],
        ];
    }

    public static function getOperations()
    {
        return [
            [
                'id' => '<',
                'name' => '<',
            ],
            [
                'id' => '<=',
                'name' => '<=',
            ],
            [
                'id' => '=',
                'name' => '=',
            ],
            [
                'id' => '>=',
                'name' => '>=',
            ],
            [
                'id' => '>',
                'name' => '>',
            ],
            [
                'id' => '!=',
                'name' => '!=',
            ],
            [
                'id' => 'between',
                'name' => 'Between',
            ],
        ];
    }

    public static function getOperationsByType($type)
    {
        if (in_array($type, ['date', 'datetime', 'timestamp', 'integer', 'float', 'double'])) {
            return [
                [
                    'id' => '<',
                    'name' => '<',
                ],
                [
                    'id' => '<=',
                    'name' => '<=',
                ],
                [
                    'id' => '=',
                    'name' => '=',
                ],
                [
                    'id' => '>=',
                    'name' => '>=',
                ],
                [
                    'id' => '>',
                    'name' => '>',
                ],
                [
                    'id' => '!=',
                    'name' => '!=',
                ],
                [
                    'id' => 'between',
                    'name' => 'Between',
                ],
            ];
        } else {
            return [
                [
                    'id' => '=',
                    'name' => '=',
                ],
                [
                    'id' => '%like',
                    'name' => 'Start with',
                ],
                [
                    'id' => '%like%',
                    'name' => 'Contains',
                ],
                [
                    'id' => 'like%',
                    'name' => 'End with',
                ],
            ];
        }
    }

    public static function getFormTypes()
    {
        return [
            [
                'id' => 'text',
                'name' => 'Text',
            ],
            [
                'id' => 'textarea',
                'name' => 'Text area',
            ],
            [
                'id' => 'number',
                'name' => 'Number',
            ],
            [
                'id' => 'date',
                'name' => 'Date',
            ],
            [
                'id' => 'datetime',
                'name' => 'Date time',
                'value' => 'datetime-local',
            ],
            [
                'id' => 'time',
                'name' => 'Time',
            ],
            [
                'id' => 'select',
                'name' => 'Select',
            ],
            [
                'id' => 'multiple_select',
                'name' => 'Multiple Select',
            ],
            [
                'id' => 'radio',
                'name' => 'Radio',
            ],
            [
                'id' => 'checkbox',
                'name' => 'Checkbox',
            ],
            [
                'id' => 'switch',
                'name' => 'Switch',
            ],
            [
                'id' => 'file',
                'name' => 'file',
            ],
        ];
    }

    public static function getColumnTypes()
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

    public static function getFilterTypes()
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

    public static function getFilterDateTypes()
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

    public static function getUsedColumns()
    {
        return [
            'id',
            'order',
            'user_id',
            'barcode',
            'status_id',
            'reference',
            'references',
        ];
    }
}
