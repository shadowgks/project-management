<?php

namespace App\Helpers;

use App\Models\AppModule;
use Artisan;
use Str;
use File;

class FileHelper
{
    const UPLOAD_PREFIX = 'storage';
    const DEFAULT_AVATAR = 'images/default-avatar.png';

    public static function replaceOneLineFileContent($path, $replace, $search, $line_break = true)
    {
        $new_path = base_path($path);

        if (!file_exists($new_path)) {
            File::put($new_path, '');
        }

        file_put_contents($new_path, implode(
            '',
            array_map(function ($line) use ($replace, $search, $line_break) {
                return stristr($line, $search) ? self::echo_to_file(($line_break ? $replace . '\n' : $replace)) : $line;
            }, file($new_path))
        ));
    }

    public static function replaceMultipleLinesFileContent($path, $replace, $start, $end, $line_break = true)
    {
        $new_path = base_path($path);

        if (!file_exists($new_path)) {
            File::put($new_path, '');
        }

        $data = (object)[
            'start' => $start,
            'end' => $end,
            'started' => false,
            'index' => 1,
            'line_break' => $line_break,
        ];

        file_put_contents($new_path, implode(
            '',
            array_map(function ($line) use ($replace, $data) {
                if (!$data->started && stristr($line, $data->start))
                    $data->started = true;

                if ($data->started && stristr($line, $data->end)) {
                    $data->started = false;
                    return '';
                }


                if ($data->started) {
                    if ($data->index == 1)
                        $new_content = self::echo_to_file(($data->line_break ? $replace . '\n' : $replace));
                    else
                        $new_content = '';
                    $data->index++;
                } else {
                    $new_content = $line;
                }

                return $new_content;
            }, file($new_path))
        ));
    }

    /**
     * @param string $path
     * @param string $replace
     * @param string $key
     * @param boolean $line_break
     */
    public static function replaceMultipleLinesViewWithKey($path, $replace, $key, $line_break = true)
    {
        self::replaceMultipleLinesFileContent($path, $replace, '{{-- ' . $key . ' - start --}}', '{{-- ' . $key . ' - end --}}', $line_break);
    }

    /**
     * @param string $path
     * @param string $replace
     * @param string $key
     * @param boolean $line_break
     */
    public static function replaceMultipleLinesFileWithKey($path, $replace, $key, $line_break = true)
    {
        self::replaceMultipleLinesFileContent($path, $replace, '// ' . $key . ' - start', '// ' . $key . ' - end', $line_break);
    }

    public static function echo_to_file($content)
    {
        if (Str::contains($content, '\n'))
            $new_content = Str::replace('\n', PHP_EOL, $content);
        else
            $new_content = $content;

        return $new_content;
    }

    public static function get_fields_view_content($fields, $save_type = 'file', $module_id = null, $key = null)
    {
        $form_content = '';
        if ($save_type == 'file') {
            $form_content .= '{{-- ' . (!empty($key) ? $key . ' ' : '') . 'form - start --}}';

            // foreach ($fields as $element) {
            //     if ($module_id != null)
            //         $element['app_module_id'] = $module_id;
            //     $form_content .= TemplateHelper::getFormElement($element);
            //     $form_content .= "\n";
            // }

            for ($i = 0; $i < count($fields); $i++) {
                if ($fields[$i]['active'] == false) continue;

                $element = StringHelper::search_by_key('order', $i, $fields);
                if ($element != null) {
                    if ($module_id != null)
                        $element['app_module_id'] = $module_id;

                    $form_content .= TemplateHelper::getFormElement($element, [
                        'key' => $key,
                    ]);

                    $form_content .= "\n";
                }
            }

            $form_content .= '{{-- ' . (!empty($key) ? $key . ' ' : '') . 'form - end --}}';
        } else {
            $form_content .= '@foreach ($formElements as $element)
            @if (in_array($element["type"], ["select", "radio", "checkbox"]))
                {!! TemplateHelper::getFormElement($element) !!}
            @else
                {!! TemplateHelper::getFormElement($element) !!}
            @endif
            @endforeach';
        }

        return $form_content;
    }

    public static function get_fields_controller_content($fields, $key = null)
    {
        $content = [
            'form_mount' => '// ' . (!empty($key) ? $key . ' ' : '') . 'Form mount - start' . PHP_EOL,
            'form_values' => '// ' . (!empty($key) ? $key . ' ' : '') . 'Form values - start' . PHP_EOL,
            'form_save_values' => '// ' . (!empty($key) ? $key . ' ' : '') . 'Form save values - start' . PHP_EOL,
            'form_edit_values' => '// ' . (!empty($key) ? $key . ' ' : '') . 'Form edit values - start' . PHP_EOL,
        ];

        foreach ($fields as $field) {
            if ($field['active'] == false) continue;

            if (in_array($field['type'], ['select', 'multiple_select', 'radio', 'checkbox'])) {

                if ($field['value']['type'] == 'custom') {
                    $content['form_mount'] .= '$this->base_data["' . $field['column'] . '_options"] = DropDown::select("select_id as id", "select_value as text")->where("select_field", "' . $field['column'] . '")->where("app_module_id", $this->options["module_id"])->where("select_field", "' . $field["column"] . '")->get()->toArray();' . PHP_EOL;
                } else {
                    $table_pseudo_name = (in_array($field['value']['table'], Modelhelper::default_modules) ? $field['value']['table'] : Str::replace('_', '', Str::plural($field['value']['table'])));
                    // $content['form_mount'] .= '$this->base_data["' . $field['column'] . '_options"] = ' . ModelHelper::getModelName($field['value']['table']) . '::select("id", "' . $field['value']['column'] . ' as text")->get()->toArray();';
                    if ($field['value']['table'] == 'drop_downs')
                        $content['form_mount'] .= '$this->base_data["' . $field['column'] . '_options"] = \\' . ModelHelper::getModelStringByTableNameAndModule($field['value']['table'], $table_pseudo_name) . '::select("id", "' . $field['value']['column'] . ' as text")->where("select_field", "' . $field["column"] . '")->get()->toArray();';
                    else
                        $content['form_mount'] .= '$this->base_data["' . $field['column'] . '_options"] = \\' . ModelHelper::getModelStringByTableNameAndModule($field['value']['table'], $table_pseudo_name) . '::select("id", "' . $field['value']['column'] . ' as text")->get()->toArray();';
                    $content['form_mount'] .= PHP_EOL;
                }
            }

            if (in_array($field['type'], ['checkbox', 'multiple_select', 'file'])) {
                $content['form_values'] .= '"' . $field['column'] . '" => [],' . PHP_EOL;
            } else if ($field['type'] == 'number') {
                $content['form_values'] .= '"' . $field['column'] . '" => 0,' . PHP_EOL;
            } else if ($field['type'] == 'switch') {
                $content['form_values'] .= '"' . $field['column'] . '" => ' . ($field['default'] ? 'true' : 'false') . ',' . PHP_EOL;
            } else {
                $content['form_values'] .= '"' . $field['column'] . '" => "",' . PHP_EOL;
            }

            if ($field['type'] == 'file') {
                $content['form_save_values'] .= '$files = upload_files($this->form["' . $field['column'] . '"], new ' . ModelHelper::getModelName($field['table_name']) . ', [
                    "app_module_id" => $this->appOptions["app_module_id"],
                ]);

                if ($files["count"] > 0) {
                    $images = [];
                    if ($files["count"] == 1) {
                        array_push($images, $files["file"]["id"]);
                    } else {
                        foreach ($files["files"] as $file) {
                            array_push($images, $file["id"]);
                        }
                    }

                    $data["' . $field['column'] . '"] = json_encode($images);
                }' . PHP_EOL;
            } else {
                $content['form_save_values'] .= '$data["' . $field['column'] . '"] = $this->form["' . $field['column'] . '"];' . PHP_EOL;
            }

            $content['form_edit_values'] .= '$this->form["' . $field['column'] . '"] = $test->' . $field['column'] . ';' . PHP_EOL;
        }

        $content['form_mount'] .= '// ' . (!empty($key) ? $key . ' ' : '') . 'Form mount - end';
        $content['form_values'] .= '// ' . (!empty($key) ? $key . ' ' : '') . 'Form values - end';
        $content['form_save_values'] .= '// ' . (!empty($key) ? $key . ' ' : '') . 'Form save values - end';
        $content['form_edit_values'] .= '// ' . (!empty($key) ? $key . ' ' : '') . 'Form edit values - end';
        return $content;
    }

    public static function put_view_content($fields, $paths, $save_type, $module_id)
    {
        $form_content = self::get_fields_view_content($fields, $save_type, $module_id);
        $module = AppModule::where('id', $module_id)->first();
        self::replaceMultipleLinesFileContent($paths->manage, '@include(\'' . $module->pseudo_name . '::livewire.form\')', '{{-- Form include - start --}}', '{{-- Form include - end --}}');
        self::replaceMultipleLinesFileContent($paths->form, $form_content, '{{-- form - start --}}', '{{-- form - end --}}');
    }

    public static function addListenerInProvider($listener)
    {
        $namespace_content = 'use App\Listeners\\' . $listener . ';' . PHP_EOL . '// Namespaces';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $namespace_content, '// Namespaces');

        $listener_content = '// ' . $listener . PHP_EOL . $listener . '::class,' . PHP_EOL . PHP_EOL . '// Listeners';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $listener_content, '// Listeners');
    }

    public static function addListenerInEvent($event, $listener, $module = '')
    {
        $type_of_listener = gettype($listener);

        if ($type_of_listener == 'string') {
            self::insertListenerInEvent($event, $listener, $module);
        } else {
            foreach ($listener as $ls) {
                self::insertListenerInEvent($event, $ls['name'], $module);
            }
        }
    }

    private static function insertListenerInEvent($event, $listener, $module = '')
    {
        if (empty($module)) {
            $namespace_start = 'App\Listeners\\';
        } else {
            $namespace_start = 'Modules\\' . $module . '\Listeners\\';
        }

        $namespace_content = 'use ' . $namespace_start . $listener . ';' . PHP_EOL . '// Namespaces';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $namespace_content, '// Namespaces');

        $event_content = $listener . '::class,' . PHP_EOL . '// ' . $event . ' listeners';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $event_content, '// ' . $event . ' listeners');
    }

    public static function addEventInProvider($event, $listener = [])
    {
        $namespace_content = 'use App\Events\\' . $event . ';' . PHP_EOL . '// Namespaces';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $namespace_content, '// Namespaces');

        $event_content = '// ' . $event . PHP_EOL . $event . '::class => [
            // ' . $event . ' listeners
        ],' . PHP_EOL . PHP_EOL . '// Events';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $event_content, '// Events');

        if (!empty($listener)) {
            self::addListenerInEvent($event, $listener);
        }
    }

    public static function addModuleEventInProvider($module, $event, $listener = [])
    {
        $namespace_content = 'use Modules\\' . $module . '\Events\\' . $event . ';' . PHP_EOL . '// Namespaces';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $namespace_content, '// Namespaces');

        $event_content = '// ' . $event . PHP_EOL . $event . '::class => [
            // ' . $event . ' listeners
        ],' . PHP_EOL . PHP_EOL . '// Events';
        self::replaceOneLineFileContent('app/Providers/EventServiceProvider.php', $event_content, '// Events');

        if (!empty($listener)) {
            self::addListenerInEvent($event, $listener, $module);
        }
    }

    public static function getFormSeedersContent($setting, $key = null)
    {
        $exceptions = ['id', 'user_id', 'created_at', 'updated_at'];
        $result = '// ' . (!empty($key) ? $key . ' ' : '') . 'Form seeders - start' . PHP_EOL . 'Form::insert([';

        foreach ($setting->toArray() as $key_1 => $value) {
            if (!in_array($key_1, $exceptions)) {
                $new_value = '';
                $type_of_value = gettype($value);
                if ($type_of_value == 'boolean') $new_value = ($value ? 'true' : 'false');
                else if (ModelHelper::isNumberType($type_of_value)) $new_value = $value;
                else $new_value = '\'' . $value . '\'';
                $result .= '"' . $key_1 . '" => ' . $new_value . ',' . PHP_EOL;
            }
        }

        $result .= ']);' . PHP_EOL . '// ' . (!empty($key) ? $key . ' ' : '') . 'Form seeders - end';
        return $result;
    }
}
