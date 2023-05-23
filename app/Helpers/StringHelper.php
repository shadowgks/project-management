<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class StringHelper
{
    public static function getColumnsString($columns, $operations = [], $options = [], $settings = [])
    {
        $columns_string = '';
        $columns_length = count($columns);
        $operations_length = count($operations);
        $options_length = count($options);
        $settings_length = count($settings);

        $columns_string .= 'id, ';

        if ($settings_length > 0 && in_array(true, [isset($settings['show_numbering']), isset($settings['show_barcode']), isset($settings['show_created_by'])])) {
            if ($settings['show_numbering']) {
                $columns_string .= 'reference, ';
            }

            if ($settings['show_barcode']) {
                $columns_string .= 'barcode, ';
            }

            if ($settings['show_created_by']) {
                $columns_string .= 'user_id, ';
            }
        }

        foreach ($columns as $key => $column) {
            $option_exist = false;
            $column_helper = '';

            if ($options_length > 0) {
                foreach ($options as $key_2 => $option) {
                    $option = (object) $option;

                    if ($column == $option->old_name) {
                        $option_exist = true;
                        $columns_string .= ($key + 1 == $columns_length ? $option->table . '.' . $option->name . ' as join_' . $key_2 : $option->table . '.' . $option->name . ' as join_' . $key_2 . ', ');
                        break;
                    }
                }

                if (isset($settings['number'])) {
                    if ($settings['number'] == 'price') {
                        $column = 'cast(' . $column . ' as decimal(10, 2)';
                    } else if ($settings['number'] == 'quantity') {
                        $column = 'cast(' . $column . ' as decimal(10, 3)';
                    }
                }

                if (!$option_exist) {
                    $columns_string .= ($key + 1 == $columns_length ? $column : $column . ', ');
                }
            } else {
                $used = false;
                if (isset($settings['type'])) {
                    $used = true;
                    if ($settings['type'] != '') {
                        if (gettype($settings['type']) == 'string') {
                            $column_helper = $settings['type'] . '(' . $column . ')';
                        } else if (gettype($settings['type']) == 'array') {
                            foreach ($settings['type'] as $type) {
                                if ($type['column'] == $column) {
                                    $column_helper = $type['value'] . '(' . $column . ')';
                                }
                            }
                        } else {
                            throw new \Exception('Setting type is not allowed!');
                        }
                    } else {
                        $column_helper = $column;
                    }
                }

                if (isset($settings['number'])) {
                    $used = true;
                    if ($settings['number'] == 'price') {
                        $column_helper = 'cast(' . $column_helper . ' as decimal(10, 2))';
                    } else if ($settings['number'] == 'quantity') {
                        $column_helper = 'cast(' . $column_helper . ' as decimal(10, 3))';
                    }
                }

                if ($used) {
                    $column_helper =  $column_helper . ' as ' . $column;
                } else {
                    $column_helper = $column;
                }

                $columns_string .= ($key + 1 == $columns_length ? $column_helper : $column_helper . ', ');
            }
        }

        if ($operations_length > 0) {
            $type_exist = false;

            foreach ($operations as $key => $operation) {
                $operation = (object) $operation;

                if ($operation->type == 4) {
                    if (!$type_exist) {
                        $columns_string .= ', ';
                    }

                    $type_exist = true;
                    $columns_string .= ($key + 1 == $operations_length ? '(' . $operation->value . ') as value_' . $key : '(' . $operation->value . ') as value_' . $key . ', ');
                }
            }
        }

        // if (isset($settings['buttons']) && in_array(true, [$settings['buttons']['edit'], $settings['buttons']['delete'], $settings['buttons']['print'], $settings['buttons']['validate']])) {
        //     $columns_string .= ', actions';
        // }

        return $columns_string;
    }

    public static function getColumnsStringForListing($columns, $operations = [], $options = [])
    {
        $columns_string = '';
        $columns_length = count($columns);
        $operations_length = count($operations);
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

    public static function arrayToString($columns, $operations = [], $options = [], $settings = [])
    {
        $array_string = '[';
        $columns_length = count($columns);
        $operations_length = count($operations);
        $options_length = count($options);
        $settings_length = count($settings);

        if ($options_length > 0 && isset($options['checkbox']) && $options['checkbox']) {
            $array_string .= '\'checkbox\', ';
        }

        if ($settings_length > 0 && isset($settings['show_flagged']) && $settings['show_flagged']) {
            $array_string .= '\'flagged\', ';
        }

        foreach ($columns as $key => $column) {
            $option_exist = false;

            if ($options_length > 0) {
                foreach ($options as $key_2 => $option) {
                    $option = (object) $option;

                    if ($column == $option->old_name) {
                        $option_exist = true;
                        $columns_array[$column] = $option->table . '.' . $option->name;
                        // $array_string .= ($key + 1 == $columns_length ? '\'' . $option->table . '.' . $option->name . '\'' : '\'' . $option->table . '.' . $option->name . '\'' . ', ');
                        $array_string .= ($key + 1 == $columns_length ? '\'' . 'join_' . $key_2 . '\'' : '\'' . 'join_' . $key_2 . '\'' . ', ');
                        break;
                    }
                }

                if (!$option_exist) {
                    $array_string .= ($key + 1 == $columns_length ? '\'' . $column . '\'' : '\'' . $column . '\'' . ', ');
                }
            } else {
                $array_string .= ($key + 1 == $columns_length ? '\'' . $column . '\'' : '\'' . $column . '\'' . ', ');
            }
        }

        if ($operations_length > 0) {
            $array_string .= ', ';

            foreach ($operations as $key => $operation) {
                $operation = (object) $operation;
                // $array_string .= ($key + 1 == $operations_length ? '\'value_' . $key . '\'' : '\'value_' . $key . '\', ');
                $array_string .= ($key + 1 == $operations_length ? '\'' . $operation->name . '\'' : '\'' . $operation->name . '\', ');
            }
        }

        $array_string .= ']';
        return $array_string;
    }

    public static function getColumnsArray($columns, $operations = [], $options = [])
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

    public static function joinToString($joins, $options = [])
    {
        $query_name = 'data';
        if (isset($options['query_name'])) {
            $query_name = $options['query_name'];
        }

        $join_string = '$' . $query_name . ' = ';

        $type = 'query';
        if (isset($options['type'])) {
            $type = $options['type'];
        }

        if ($type == 'query') {
            foreach ($joins as $key => $join) {
                $join_string .= ($key == 0 ? '$' . $query_name . '->leftJoin(\'' . $join[0] . '\', \'' . $join[1] . '\', \'' . $join[2] . '\', \'' . $join[3] . '\')' : '->leftJoin(\'' . $join[0] . '\', \'' . $join[1] . '\', \'' . $join[2] . '\', \'' . $join[3] . '\')');
            }
        } else if ($type == 'eloquent') {
            foreach ($joins as $key => $join) {
                $join_string .= '$' . $query_name . '->with(\'' . $join . '\');';
            }
        } else {
            throw new \Exception($type . ' is not allowed!');
        }

        return $join_string;
    }

    public static function printData($column, $row, $type = null)
    {
        if (str_contains($column, '.')) {
            $new_value = $row;
            $value_helper = explode('.', $column);

            foreach ($value_helper as $value) {
                if ($new_value != null) {
                    $new_value = $new_value[$value];
                }
            }

            $row[$column] = $new_value;
        }

        if ($row[$column] != null) {
            if (ModelHelper::isDateType($type))
                if ($type == 'date')
                    return Carbon::parse($row[$column])->format('d/m/Y');
                else if ($type == 'time')
                    return Carbon::parse($row[$column])->format('H:i');
                else
                    return Carbon::parse($row[$column])->format('d/m/Y H:i');
            else
                return $row[$column];
        } else {
            return '-';
        }
    }

    public static function getFileNames($name)
    {
        $name = Str::lower($name);
        $title = Str::title($name);

        return [
            'name' => $name,
            'title' => $title,
            'blade' => $name . '-view',
            'controller' => $title . 'Controller',
        ];
    }

    public static function arrayKeyToString($array, $object = true)
    {
        $string = '[';

        foreach ($array as $arr) {
            if ($object)
                $string .= '(object) [';
            else
                $string .= '[';

            foreach ($arr as $key => $value) {
                $string .= '\'' . $key . '\'' . ' => ' . (gettype($value) == 'string' ? '\'' . $value . '\'' : ($value ?? 'null')) . ', ';
            }
            $string .= '], ';
        }

        $string .= ']';
        return $string;
    }

    public static function oneSimpleArrayKeyToString($array, $prefex, $object = true)
    {
        if ($object)
            $string = '(object) [';
        else
            $string = '[';

        foreach ($array as $key => $value) {
            $string .= '\'' . $value[$prefex] . '\'' . ' => ' . (gettype($value[$prefex]) == 'string' ? '\'' . $value[$prefex] . '\'' : ($value[$prefex] ?? 'null')) . ', ';
        }

        $string .= ']';
        return $string;
    }

    public static function getListingOptions($settings)
    {
        $string = '';
        $settings_array = [
            $settings['show_numbering'],
            $settings['show_barcode'],
            $settings['show_created_by'],
            ($settings['show_flagged'] ?? null),
            $settings['buttons']['edit'],
            $settings['buttons']['delete'],
            $settings['buttons']['print'],
            $settings['buttons']['validate'],
        ];

        if (in_array(true, $settings_array)) {
            if ($settings['show_numbering']) {
                $string .= '
                    $data = $data->editColumn(\'reference\', function($row){
                        return \'<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', \' . $row["id"] . \')" wire:click="show_row(\' . $row["id"] . \')">\' . $row["reference"] . \'</a>\';
                    });
                ';
            }

            if ($settings['show_barcode']) {
                $string .= '
                    $data = $data->addColumn(\'barcode\', function($row){
                        return $row["barcode"];
                    });
                ';
            }

            if ($settings['show_created_by']) {
                $string .= '
                    $data = $data->addColumn(\'created_by_name\', function($row){
                        return $row["created_by"] == null ? "-" : $row["created_by"]["first_name"] . " " . $row["created_by"]["last_name"];
                    });
                ';
            }

            if (isset($settings['show_flagged']) && $settings['show_flagged']) {
                $string .= '
                    $data = $data->editColumn(\'flagged\', function($row) {
                        $bool = (isset($row["flagged"]) ? $row["flagged"] : false);

                        return \'<a href="#" class="btn btn-icon btn-color-gray-400 btn-active-color-primary w-35px h-35px \' . ($bool ? \'active\' : \'\') . \'" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Mark as important" data-bs-original-title="Mark as important" data-kt-initialized="1">

                            <span class="svg-icon svg-icon-4 mt-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </a>\';
                    });
                ';
            }

            if (in_array(true, [$settings['buttons']['edit'], $settings['buttons']['delete'], $settings['buttons']['print'], $settings['buttons']['validate']])) {
                $string .= '
                    $data = $data->addColumn(\'actions\', function($row) use ($permissions) {
                        $btn = "<p class=\"text-end mb-0\">";
                ';

                if ($settings['buttons']['edit'])
                    $string .= '
                    if ($permissions["update"]) {
                        $btn .= \'<button type="button" class="btn btn-secondary btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\\\'editData\\\', \' . $row["id"] . \')" wire:click="editDataP(\' . $row["id"] . \')">
                            <i class="la la-pencil p-0"></i>
                        </button>\';
                    }
                    ';

                if ($settings['buttons']['validate'])
                    $string .= '$btn .= \'<button type="button" class="btn btn-success btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\\\'validateData\\\', \' . $row["id"] . \')" wire:click="validateDataP(\' . $row["id"] . \')">
                        <i class="la la-check p-0"></i>
                    </button>\';';

                if ($settings['buttons']['print'])
                    $string .= '$btn .= \'<button type="button" class="btn btn-primary btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\\\'printData\\\', \' . $row["id"] . \')" wire:click="printDataP(\' . $row["id"] . \')">
                        <i class="la la-print p-0"></i>
                    </button>\';';

                if ($settings['buttons']['delete'])
                    $string .= '
                    if ($permissions["delete"]) {
                        $btn .= \'<button type="button" class="btn btn-danger btn-shadow btn-icon btn-sm" onclick="liveCall(\\\'deleteData\\\', \' . $row["id"] . \')" wire:click="deleteDataP(\' . $row["id"] . \')">
                            <i class="la la-trash p-0"></i>
                        </button>\';
                    }
                    ';

                $string .= '$btn .= "</p>";
                return $btn;
                });';
            }
        }

        return $string;
    }

    public static function search_by_key($search_key, $search_value, $array)
    {
        foreach ($array as $key => $value) {
            if ($value[$search_key] == $search_value)
                return $value;
        }

        return null;
    }

    public static function getErrorAlertMessage($messages)
    {
        $string = '';

        foreach ($messages as $message) {
            $string .= $message . PHP_EOL;
        }

        return $string;
    }

    public static function getValidatorMessages($validator)
    {
        $string = '';

        foreach ($validator->messages()->toArray() as $input) {
            foreach ($input as $message) {
                $string .= $message . PHP_EOL;
            }
        }

        return $string;
    }

    public static function getModelVariable($model)
    {
        $variables = explode('.', $model);
        return [
            'parent' => $variables[0],
            'model' => Str::substr($model, Str::length($variables[0]) + 1),
        ];
    }

    /**
     * @return string
     */
    public static function getTitle($text)
    {
        return Str::ucfirst(Str::replace('_', ' ', $text));
    }

    // public static function isDataEmpty($data, $keys)
    // {
    //     $result = true;

    //     foreach ($keys as $key) {
    //         if (empty($data[$key['name']])) {
    //             $result = false;
    //             $this->options['errors'][$key['error']] = [
    //                 'show' => true,
    //                 'message' => $key['message_name'] . ' ' . __('is required!'),
    //                 'color' => 'danger',
    //             ];
    //         } else {
    //             $this->options['errors'][$key['error']] = [
    //                 'show' => false,
    //                 'message' => '',
    //                 'color' => '',
    //             ];
    //         }
    //     }

    //     return $result;
    // }

    // public static function isDataExists($data, $keys)
    // {
    //     $result = true;

    //     foreach ($keys as $key) {
    //         if (empty($data[$key['name']])) {
    //             $result = false;
    //             $this->options['errors'][$key['error']] = [
    //                 'show' => true,
    //                 'message' => $key['message_name'] . ' ' . __('is required!'),
    //                 'color' => 'danger',
    //             ];
    //         } else {
    //             $this->options['errors'][$key['error']] = [
    //                 'show' => false,
    //                 'message' => '',
    //                 'color' => '',
    //             ];
    //         }
    //     }

    //     return $result;
    // }

    /**
     * @param string $lastUsedSerialNumber
     * @return string
     */
    public static function getSerialNumber($lastUsedSerialNumber)
    {
        if ($lastUsedSerialNumber == null)
            $lastUsedSerialNumber = 'AAA-000';

        $parts = explode('-', $lastUsedSerialNumber);
        // if second part is 999, increment first part, from AAB to AAC, and set
        // second sequence to 000;
        if ((int) $parts[1] === 999) {
            $parts[0] = $parts[0]++;
            $parts[1] = 000;
        }
        // increment second sequence if lower than 999
        if ((int) $parts[1] < 999) {
            $parts[1] = str_pad(
                ++$parts[1],
                3,
                '0',
                STR_PAD_LEFT
            );
        }
        return $parts[0] . '-' . $parts[1];
    }
}
