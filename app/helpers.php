<?php

use App\Helpers\FileHelper;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Upload;
use App\Models\User;
use App\Models\UserPermission;

if (!function_exists('get_svg_icon')) {
    function get_svg_icon($path, $class = null, $svgClass = null)
    {
        if (strpos($path, 'media') === false) {
            $path = theme()->getMediaUrlPath() . $path;
        }

        $file_path = public_path($path);

        if (!file_exists($file_path)) {
            return '';
        }

        $svg_template = file_get_contents($file_path);

        if (empty($svg_template)) {
            return '';
        }

        $dom = new DOMDocument();
        $dom->loadXML($svg_template);

        // remove unwanted comments
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // add class to svg
        if (!empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $xpath = $dom->getElementsByTagName('path');
        foreach ($xpath as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');

        if (!empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        $asd = explode('/media/', $path);
        if (isset($asd[1])) {
            $path = 'assets/media/' . $asd[1];
        }

        $output = "<!--begin::Svg Icon | path: $path-->\n";
        $output .= '<span class="' . implode(' ', $cls) . '">' . $string . '</span>';
        $output .= "\n<!--end::Svg Icon-->";

        return $output;
    }
}

if (!function_exists('theme')) {
    /**
     * Get the instance of Theme class core
     *
     * @return \App\Core\Adapters\Theme|\Illuminate\Contracts\Foundation\Application|mixed
     */
    function theme()
    {
        return app(\App\Core\Adapters\Theme::class);
    }
}

if (!function_exists('util')) {
    /**
     * Get the instance of Util class core
     *
     * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
     */
    function util()
    {
        return app(\App\Core\Adapters\Util::class);
    }
}

if (!function_exists('bootstrap')) {
    /**
     * Get the instance of Util class core
     *
     * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
     * @throws Throwable
     */
    function bootstrap()
    {
        $demo = ucwords(theme()->getDemo());
        $bootstrap = "\App\Core\Bootstraps\Bootstrap$demo";

        if (!class_exists($bootstrap)) {
            abort(404, 'Demo has not been set or ' . $bootstrap . ' file is not found.');
        }

        return app($bootstrap);
    }
}

if (!function_exists('assetCustom')) {
    /**
     * Get the asset path of RTL if this is an RTL request
     *
     * @param $path
     * @param  null  $secure
     *
     * @return string
     */
    function assetCustom($path)
    {
        // Include rtl css file
        if (isRTL()) {
            return asset(theme()->getDemo() . '/' . dirname($path) . '/' . basename($path, '.css') . '.rtl.css');
        }

        // Include dark style css file
        if (theme()->isDarkModeEnabled() && theme()->getCurrentMode() !== 'light') {
            $darkPath = str_replace('.bundle', '.' . theme()->getCurrentMode() . '.bundle', $path);
            if (file_exists(public_path(theme()->getDemo() . '/' . $darkPath))) {
                return asset(theme()->getDemo() . '/' . $darkPath);
            }
        }

        // Include default css file
        return asset(theme()->getDemo() . '/' . $path);
    }
}

if (!function_exists('isRTL')) {
    /**
     * Check if the request has RTL param
     *
     * @return bool
     */
    function isRTL()
    {
        return isset($_REQUEST['rtl']) && $_REQUEST['rtl'] || (isset($_COOKIE['rtl']) && $_COOKIE['rtl']);
    }
}

if (!function_exists('preloadCss')) {
    /**
     * Preload CSS file
     *
     * @return bool
     */
    function preloadCss($url)
    {
        return '<link rel="preload" href="' . $url . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" type="text/css"><noscript><link rel="stylesheet" href="' . $url . '"></noscript>';
    }
}

if (!function_exists('isDarkSidebar')) {
    function isDarkSidebar()
    {
        if (isset($_COOKIE['layout'])) {
            if ($_COOKIE['layout'] === 'dark-sidebar') {
                return true;
            }
            if ($_COOKIE['layout'] === 'light-sidebar') {
                return false;
            }
        } else {
            return theme()->getOption('layout', 'aside/theme') === 'dark';
        }

        return true;
    }
}
if (!function_exists('get_current_theme_from_settings')) {
    function get_current_theme_from_settings()
    {
        // return 'demo1';
        $theme = get_fields_by_key('theme', 'key', 'settings', 'value');
        // $theme = Setting::where('key', 'theme')->first();
        if ($theme == null) {
            return 'demo1';
        }
        return $theme;
    }
}
if (!function_exists('get_fields_by_key')) {
    function get_fields_by_key($field_value, $field_name, $table, $field)
    {
        $data = DB::table($table)
            ->where($field_name, $field_value)
            ->pluck($field);

        if (count($data) > 1) {
            return $data;
        }
        foreach ($data as $d) {
            return $d;
        }
    }
}
if (!function_exists('get_class_names')) {
    function get_class_names()
    {

        $class_array[] = 'userClass';

        // Add class name

        return $class_array;

        // $class_array = [globalClass::class,invoiceClass::class];
        // return $class_array;
    }
}
if (!function_exists('get_value_by_key')) {
    function get_value_by_key($key_name, $key_value, $table, $value_field_name)
    {
        $data = DB::table($table)
            // ->select($field)
            ->where($key_name, $key_value)
            ->pluck($value_field_name);

        foreach ($data as $d) {
            return $d;
        }

        // $class_array = [globalClass::class,invoiceClass::class];
        // return $class_array;
    }
}

if (!function_exists('get_module_code')) {
    function get_module_code($table, $rel_type, $rel_id)
    {
        $code = get_fields_by_key($rel_id, 'id', $rel_type, 'reference');

        $module_id = get_fields_by_key($rel_type, 'name', 'app_modules', 'id');
        $reference_id = get_fields_by_key($module_id, 'app_module_id', 'numbering_settings', 'id');

        $data = DB::table($table)
            ->where('numbering_setting_id', $reference_id)
            ->first();

        $number_length = $data->number_length;
        $elements = json_decode($data->elements);
        $number = $code;

        $elements = collect($elements)->sortBy('order')->toArray();
        foreach ($elements as $element) {
            if ($element->type == 'static') {
                $prefix = $element->value;
                $number = str_replace($prefix, "", $number);
            }

            if ($element->type == 'number') {
                $number_order = $element->order;
            }
            if ($element->type == 'date') {
                $date_order = $element->order;
                if ($element->value == 'y') {
                    $nbr_digit = 4;
                } else {
                    $nbr_digit = 2;
                }
            }
        }

        if ($number_order > $date_order) {
            $number = substr($number, '-' . $number_length);
        } else {
            $number = substr($number, 0, $number_length);
        }
        return $number;
    }
}

if (!function_exists('get_merge_fields')) {
    function get_merge_fields($app_module_id, $module_id, $field_name, $field_value)
    {
        $table = get_fields_by_key($app_module_id, 'id', 'app_modules', 'name');
        $merge_fields = [];
        $i = 0;
        $all_tags = [];
        $classes = get_class_names();
        foreach (get_class_names() as $class) {

            $class_tags = app($class)->get_all_tags();

            foreach ($class_tags as $class_tag) {
                $tag_templates = get_fields_by_key($class_tag['key'], 'variable', 'variable_templates', $field_name);
                $class_tag['templates'] = json_decode($tag_templates);
                if ($class_tag['templates'] && in_array($field_value, $class_tag['templates'])) {
                    array_push($all_tags, $class_tag);
                }
            }
        }

        foreach ($all_tags as $tag) {
            $data = $tag['value'];
            if ($data['type'] == 'simple') {

                $value = get_fields_by_key($module_id, $data['field_name'], $data['table'], $tag['key']);
                $merge_fields[$i]['key'] = $tag['key'];
                $merge_fields[$i]['value'] = $value;
                $i++;
            }

            if ($data['type'] == 'join') {
                $field_value = get_fields_by_key($module_id, 'id', $table, $data['field_name']);
                $value = get_fields_by_key($field_value, $data['id_field_name'], $data['table'], $tag['key']);
                $merge_fields[$i]['key'] = $tag['key'];
                $merge_fields[$i]['value'] = $value;
                $i++;
            }

            if ($data['type'] == 'global') {

                $value = get_value_by_key($data['key_field_name'], $tag['key'], $data['table'], $data['value_field_name']);
                $merge_fields[$i]['key'] = $tag['key'];
                $merge_fields[$i]['value'] = $value;
                $i++;
            }
        }

        return $merge_fields;
    }
}

if (!function_exists('get_pdf_template')) {
    function get_pdf_template($app_module_id, $module_id)
    {
        // $rel_type = get_fields_by_key($rel_type, 'id', 'app_modules', 'name');
        //  $fields=get_merge_fields($app_module_id,$module_id,'app_module_ids',$app_module_id);

        $pdf_template = DB::table('pdf_templates')
            ->where('app_module_id', $app_module_id)
            ->first();

        $fields = get_merge_fields_values($app_module_id, $pdf_template->id, $module_id);

        $message = $pdf_template->template;

        foreach ($fields as $field) {
            $key = '{ ' . $field['name'] . ' }';

            $message = str_replace($key, $field['value'], $message);
        }

        return $message;
    }
}

if (!function_exists('module_permission_name')) {
    // enum Permission_types {
    // case create;
    // case update;
    // case delete;
    // case view;
    // case view_own;
    // case view_comments;
    // case create_comments;
    // case view_reminders;
    // case create_reminders;
    // case view_file_upload;
    // case create_file_upload;
    // }

    function module_permission_name($module_name, $type)
    {
        $module = str_replace(array('[', ']', ' ', '"', '"'), '', strtolower($module_name));
        switch ($type) {
            case "create":
                return "create_" . $module . "_permission";
                break;

            case "view":
                return "view_" . $module . "_permission";
                break;

            case "view_own":
                return "view_own_" . $module . "_permission";
                break;

            case "update":
                return "update_" . $module . "_permission";
                break;

            case "delete":
                return "delete_" . $module . "_permission";
                break;

            case "view_comments":
                return "view_" . $module . "_comments_permission";
                break;

            case "create_comments":
                return "create_" . $module . "_comments_permission";
                break;

            case "view_reminders":
                return "view_" . $module . "_reminders_permission";
                break;

            case "create_reminders":
                return "create_" . $module . "_reminders_permission";
                break;

            case "view_file_upload":
                return "view_" . $module . "_file_upload_permission";
                break;

            case "create_file_upload":
                return "create_" . $module . "_file_upload_permission";
                break;
            default:
                return null;
                break;
        }
    }
}
if (!function_exists('generate_email_template_permission')) {

    function generate_email_template_permission($template, $type)
    {
        if ($type == 'send_email') {
            return "send_" . $template . "_permission";
        } elseif ($type == 'receive_email') {
            return "receive_" . $template . "_permission";
        } else {
            return null;
        }
    }
}
if (!function_exists('available_permissions')) {
    function available_permissions($module_name, $type)
    {
        $results = [];
        $module_name = strtolower($module_name);

        if ($type == 'basic') {
            //NOTE - View permission
            array_push($results, "view_" . $module_name . "_permission");
            //NOTE - View own permission
            array_push($results, "view_own_" . $module_name . "_permission");

            //NOTE - Creation permission
            array_push($results, "create_" . $module_name . "_permission");
            //NOTE - Update permission
            array_push($results, "update_" . $module_name . "_permission");
            //NOTE - Delete permission
            array_push($results, "delete_" . $module_name . "_permission");
        } elseif ($type = 'advanced') {
            //NOTE - Comments
            array_push($results, "view_" . $module_name . "_comments_permission");
            array_push($results, "create_" . $module_name . "_comments_permission");
            //NOTE - Reminders
            array_push($results, "view_" . $module_name . "_reminders_permission");
            array_push($results, "create_" . $module_name . "_reminders_permission");
            //NOTE - File upload
            array_push($results, "view_" . $module_name . "_file_upload_permission");
            array_push($results, "create_" . $module_name . "_file_upload_permission");
        }
        return $results;
    }
}
if (!function_exists('can_send_email_template')) {
    function can_send_email_template($template)
    {
        $permission_name = "send_" . $template . "_permission";
        $permission = Permission::where('pseudo_name', $permission_name)->first();
        return UserPermission::where('permission_id', $permission->id)->where('user_id', Auth::user()->id)->first()->value;
    }
}
/*

Return the users that want to receive emails of this template

 */
if (!function_exists('want_to_receive_email_template')) {
    function want_to_receive_email_template($template)
    {
        $permission_name = "receive_" . $template . "_permission";

        $permission = Permission::where('pseudo_name', $permission_name)->first();
        return UserPermission::select('user_id')->where('permission_id', $permission->id)->where('value', true)->get();
    }
}
if (!function_exists('is_admin')) {
    function is_admin($user)
    {
        $result = false;
        if (isset($user)) {
            ($user->is_admin == 1) ? $result = true : $result = false;
        }
        return $result;
    }
}
if (!function_exists('has_permission')) {
    function has_permission($permission, $user_id)
    {
        $permission = Permission::where('pseudo_name', $permission)->first();
        if (isset($permission)) {

            $user_permission = UserPermission::where('user_id', $user_id)->where('permission_id', $permission->id)->first();
            $user = User::find($user_id);
            switch ($permission->category) {
                case "module":
                    if (is_admin($user)) {
                        return true;
                    } else {
                        return $user_permission->value;
                    }
                    break;
                case "notification":
                    return $user_permission->value;
                case "pdf":
                    if (is_admin($user)) {
                        return true;
                    } else {
                        return $user_permission->value;
                    }
                    break;
                case "validation":
                    if (is_admin($user)) {
                        return true;
                    } else {
                        return $user_permission->value;
                    }
                    break;
            }
        }
    }
}
if (!function_exists('has_permission_by_id')) {
    function has_permission_by_id($permission_id, $user_id)
    {
        $permission = Permission::find($permission_id);
        if (isset($permission)) {
            $user_permission = UserPermission::where('user_id', $user_id)->where('permission_id', $permission->id)->first();
            $user = User::find($user_id);
            switch ($permission->category) {
                case "module":
                    if (is_admin($user)) {
                        return true;
                    } else {
                        return $user_permission->value;
                    }

                    break;
                case "notification":
                    return $user_permission->value;
                case "pdf":
                    if (is_admin($user)) {
                        return true;
                    } else {
                        return $user_permission->value;
                    }
                    break;
                case "validation":
                    if (is_admin($user)) {
                        return true;
                    } else {
                        return $user_permission->value;
                    }
                    break;
            }
        }
    }
}

if (!function_exists('get_merge_fields_values')) {
    function get_merge_fields_values($app_module_id, $template_id, $module_id)
    {
        $temmplate_variables = DB::table('templates_variables')
            ->where('template_id', $template_id)
            ->where('template_type', 1)
            ->get();
        $all_tags = [];
        //  ->pluck('variable_id');

        $varibles = DB::table('variables')
            ->where('always_available', 1)
            ->get();
        foreach ($varibles as $var) {
            array_push($all_tags, $var);
        }

        foreach ($temmplate_variables as $var) {
            $varible = DB::table('variables')
                ->where('id', $var->variable_id)
                ->first();
            array_push($all_tags, $varible);
        }

        $all_tags = get_all_tags($template_id);
        // print_r($all_tags);
        // die();

        $table = get_fields_by_key($app_module_id, 'id', 'app_modules', 'name');
        $i = 0;
        $merge_fields = [];

        foreach ($all_tags as $tag) {
            $data = json_decode($tag->value);
            //    print_r($tag);
            //    print_r('<hr>');
            //    print_r($data);

            if ($data->type == 'simple') {

                $value = get_fields_by_key($module_id, $data->field_name, $data->table, $data->key);
                $merge_fields[$i]['key'] = $data->key;
            }

            if ($data->type == 'join') {
                $field_value = get_fields_by_key($module_id, 'id', $table, $data->field_name);
                $value = get_fields_by_key($field_value, $data->id_field_name, $data->table, $data->key);
                $merge_fields[$i]['key'] = $data->key;
            }

            if ($data->type == 'global') {

                $value = get_value_by_key($data->key_field_name, $data->key, $data->table, $data->value_field_name);
                $merge_fields[$i]['key'] = $data->key;
            }
            $merge_fields[$i]['name'] = $tag->name;
            $merge_fields[$i]['value'] = $value;
            $i++;
        }

        return $merge_fields;
    }
}

if (!function_exists('get_all_tags')) {

    function get_all_tags($template_id)
    {
        $temmplate_variables = DB::table('templates_variables')
            ->where('template_id', $template_id)
            ->where('template_type', 1)
            ->get();
        $all_tags = [];

        $varibles = DB::table('variables')
            ->where('always_available', 1)
            ->get();

        foreach ($varibles as $var) {
            array_push($all_tags, $var);
        }

        foreach ($temmplate_variables as $var) {
            $varible = DB::table('variables')
                ->where('id', $var->variable_id)
                ->first();
            array_push($all_tags, $varible);
        }

        return $all_tags;
    }
}

if (!function_exists('get_all_tags_by_group')) {

    function get_all_tags_by_group($template_id)
    {

        $all_tags = get_all_tags($template_id);
        $result = [];

        $groups = DB::table('variables')
            ->distinct()
            ->pluck('group');

        foreach ($groups as $grp) {
            $res = [];
            $i = 0;
            $res['name'] = $grp;
            foreach ($all_tags as $tag) {
                if ($tag->group == $grp) {
                    $res['tags'][$i] = $tag;
                    $i++;
                }
            }

            if ($i > 0) {
                array_push($result, $res);
            }
        }

        return $result;
    }
}

if (!function_exists('get_app_menu')) {
    function get_app_menu()
    {
        $static_items = [
            // Dashboard
            [
                'title' => 'Dashboard',
                'path' => '',
                'icon' => [
                    'font' => 'house',
                ],
            ],

            // Project
            [
                'title' => 'Project',
                'icon' => [
                    'font' => 'diagram-project',
                ],
                'route' => [
                    'name' => 'project.index',
                ],
            ],

            // Module
            [
                'title' => 'Module',
                'attributes' => [
                    "data-kt-menu-trigger" => "click",
                ],
                'icon' => [
                    'font' => 'grip',
                ],
                'show' => true,
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'Create',
                            'icon' => [
                                'font' => 'pencil',
                            ],
                            'path' => '/module',
                            'show' => true,
                        ],
                        [
                            'title' => 'Modules',
                            'icon' => [
                                'font' => 'rectangle-list',
                            ],
                            'path' => '/module/modules',
                            'show' => true,
                        ],
                        [
                            'title' => 'Menu',
                            'icon' => [
                                'font' => 'bars',
                            ],
                            'route' => [
                                'name' => 'module.menu',
                            ],
                            'show' => true,
                        ],
                        [
                            'title' => 'Forms',
                            'icon' => [
                                'font' => 'indent',
                            ],
                            'path' => '/module/template-form',
                            'show' => true,
                        ],
                        [
                            'title' => 'Numbering',
                            'icon' => [
                                'font' => 'hashtag',
                            ],
                            'path' => '/module/numbering',
                            'show' => true,
                        ],
                        [
                            'title' => 'Barcode',
                            'icon' => [
                                'font' => 'barcode',
                            ],
                            'path' => '/module/barcode',
                            'show' => true,
                        ],
                        [
                            'title' => 'Lists',
                            'icon' => [
                                'font' => 'table-list',
                            ],
                            'path' => '/module/lists',
                            'show' => true,
                        ],
                        [
                            'title' => 'Filters',
                            'icon' => [
                                'font' => 'list',
                            ],
                            'path' => '/module/filters',
                            'show' => true,
                        ],
                        [
                            'title' => 'Charts',
                            'icon' => [
                                'font' => 'chart-simple',
                            ],
                            'path' => '/module/charts',
                            'show' => true,
                        ],
                        [
                            'title' => 'Dropdowns',
                            'icon' => [
                                'font' => 'list',
                            ],
                            'path' => '/module/dropdowns',
                            'show' => true,
                        ],
                    ],
                ],
            ],

            // PDF
            [
                'title' => 'PDF',
                'attributes' => [
                    "data-kt-menu-trigger" => "click",
                ],
                'icon' => [
                    'font' => 'file-pdf',
                ],
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'Header & footer',
                            'icon' => [
                                'font' => 'hand-point-up',
                            ],
                            'path' => '/pdf/header-footer',
                        ],
                        [
                            'title' => 'Template',
                            'icon' => [
                                'font' => 'brush',
                            ],
                            'path' => '/pdf/template',
                        ],
                    ],
                ],
            ],

            // Examples
            [
                'title' => 'Examples',
                'attributes' => [
                    "data-kt-menu-trigger" => "click",
                ],
                'icon' => [
                    'font' => 'cubes',
                ],
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'Components',
                            'icon' => [
                                'font' => 'cube',
                            ],
                            'path' => '/examples',
                        ],
                        [
                            'title' => 'First Template',
                            'icon' => [
                                'font' => '1',
                            ],
                            'path' => '/templates/demo1',
                        ],
                        [
                            'title' => 'Second Template',
                            'icon' => [
                                'font' => '2',
                            ],
                            'path' => '/templates/demo2',
                        ],
                        [
                            'title' => 'Third Template',
                            'icon' => [
                                'font' => '3',
                            ],
                            'path' => '/templates/demo3',
                        ],
                        [
                            'title' => 'Fourth Template',
                            'icon' => [
                                'font' => '4',
                            ],
                            'path' => '/templates/demo4',
                        ],
                        [
                            'title' => 'Fifth Template',
                            'icon' => [
                                'font' => '5',
                            ],
                            'path' => '/templates/demo5',
                        ],
                        [
                            'title' => 'Invoice Template',
                            'icon' => 'file-invoice-dollar',
                            'icon' => [
                                'font' => 'file-invoice-dollar',
                            ],
                            'path' => '/templates/invoice',
                        ],
                    ],
                ],
            ],

            // Settings
            [
                'title' => 'Settings',
                'icon' => [
                    'font' => 'gear',
                ],
                'route' => [
                    'name' => 'settings.index',
                ],
            ],
        ];

        // $menu_items = [];

        return $static_items;
    }
}

if (!function_exists("FindReplace")) {
    function FindReplace($content, $tagOne, $tagTwo, $reppar)
    {
        $startTagPos = strrpos($content, $tagOne);
        $endTagPos = strrpos($content, $tagTwo);
        $tagLength = $endTagPos - $startTagPos + 1;
        $text = substr_replace($content, $tagOne . $reppar . '^FS ^' . $tagTwo, $startTagPos, $tagLength);
        return $text;
    }
}

if (!function_exists('get_menu_items')) {
    function get_menu_items()
    {

        $user_id = Auth::id();
        $menu_items = Menu::orderByAsc('item_order')->where('category', '!=', 'sub_element')->get();

        $menu = [];
        foreach ($menu_items as $menu_item) {
            if (has_permission_by_id($menu_item->permission_id, $user_id)) {

                if ($menu_item->category == 'simple') {
                    $new_item['title'] = $menu_item->name;
                    $new_item['path'] = $menu_item->path;
                    $new_item['icon'] = $menu_item->icon;
                } elseif ($menu_item->category == 'separator') {
                    $new_item['class'] = array('content' => 'pt-8 pb-2');
                    $new_item['content'] = '<span class="menu-section text-muted text-uppercase fs-8 ls-1">' . $menu_item->name . '</span>';
                } elseif ($menu_item->category == 'dropdown') {

                    $sub_elements = Menu::where('category', 'sub_element')->where('source', $menu_item->id)->orderByAsc('item_order')->get();
                    $new_item['title'] = array('content' => 'pt-8 pb-2');
                    $new_item['icon'] = array(
                        'font' => $menu_item->icon,
                    );
                    $new_item['classes'] = array('item' => 'menu-accordion');
                    $new_item['attributes'] = array(
                        "data-kt-menu-trigger" => "click",
                    );
                    $new_item['sub'] = [];
                    $new_item['sub']['class'] = 'menu-sub-accordion menu-active-bg';

                    $new_item['sub']['class']['items'] = [];
                    foreach ($sub_elements as $sub_element) {
                        $new_sub_element['title'] = $sub_element->name;
                        $new_sub_element['path'] = $sub_element->path;
                        $new_sub_element['icon'] = $sub_element->icon;

                        array_push($new_item['sub']['class']['items'], $new_sub_element);
                    }
                    array_push($menu, $new_item);
                }
            }
        }
        return ($menu);
    }
}

if (!function_exists('_d')) {
    function _d($date)
    {
        return Carbon\Carbon::parse($date)->format('d/m/Y');
    }
}

if (!function_exists('_t')) {
    function _t($date)
    {
        return Carbon\Carbon::parse($date)->format('H:i');
    }
}

if (!function_exists('_dt')) {
    function _dt($date)
    {
        return Carbon\Carbon::parse($date)->format('d/m/Y H:i');
    }
}

if (!function_exists('_dfh')) {
    function _dfh($date)
    {
        return Carbon\Carbon::parse($date)->diffForhumans();
    }
}

// if (!function_exists('getFileType')) {
//     function getFileType($extension)
//     {
//         //
//     }
// }

if (!function_exists('upload_files')) {
    /**
     * @param object|array subject
     * subject:
     * - type (string)
     * - name (string)
     *
     * options:
     * - path (string)
     * - app_module_id (int)
     * - properties (array)
     *
     * @return array
     * One file: [
     *  'count' => 1,
     *  'file' => object,
     * ]
     *
     * Many files: [
     *  'count' => count_files,
     *  'files' => array_of_objects,
     * ]
     *
     * Zero file: [
     *  'count' => 0,
     *  'files' => null,
     * ]
     */
    function upload_files($files, $subject, $options = [])
    {
        if (is_object($subject)) {
            $subject_type = get_class($subject);
            $subject_name = class_basename($subject);
        } else if (is_array($subject)) {
            $subject_type = $subject['type'];
            $subject_name = $subject['name'];
        } else {
            throw new \Exception('$subject must be type object or array!');
        }

        if (isset($options['path'])) {
            $path = $options['path'];
        } else {
            $path = 'public/' . $subject_name . '/' . $subject['id'] . '/';
        }

        $saved = [];
        foreach ($files as $file) {
            $_file = $file->getClientOriginalName();
            $file_name = pathinfo($_file, PATHINFO_FILENAME);
            $extension = pathinfo($_file, PATHINFO_EXTENSION);
            $file_size = $file->getSize();
            // $type = self::getFileType($extension);
            $new_file_name = getNewFileName($path, $_file);
            $full_name = $new_file_name . '.' . $extension;
            Storage::disk('local')->putFileAs($path, $file, $full_name);

            $arraySave = [
                'file_name' => $new_file_name,
                'full_name' => $full_name,
                'original_name' => $file_name,
                'path' => $path . $full_name,
                'file_size' => $file_size,
                'extension' => $extension,
                // 'type' => $type,
                'subject_type' => $subject_type,
                'subject_id' => $subject['id'],
            ];

            if (isset($options['app_module_id'])) {
                $arraySave['app_module_id'] = $options['app_module_id'];
            }

            if (isset($options['properties'])) {
                $arraySave['properties'] = $options['properties'];
            }

            $saved_id = Upload::_save($arraySave);

            $arraySave['id'] = $saved_id;
            array_push($saved, $arraySave);
        }

        $count_saved = count($saved);
        if ($count_saved == 1)
            return [
                'count' => $count_saved,
                'file' => $saved[0],
            ];
        else if ($count_saved > 1)
            return [
                'count' => $count_saved,
                'files' => $saved,
            ];
        else
            return [
                'count' => 0,
                'files' => null,
            ];
    }
}

if (!function_exists('getNewFileName')) {
    function getNewFileName($path, $file_name)
    {
        if ($pos = strrpos($file_name, '.')) {
            $name = substr($file_name, 0, $pos);
            $ext = substr($file_name, $pos);
        } else {
            $name = $file_name;
        }

        $newpath = $path . $file_name;
        $newname = pathinfo($file_name, PATHINFO_FILENAME);
        $counter = 1;

        while (Storage::disk('local')->exists($newpath)) {
            $newname = $name . ' (' . $counter . ')';
            $newpath = $path . $newname . $ext;
            $counter++;
        }

        return $newname;
    }
}

if (!function_exists('asset_upload')) {
    function asset_upload($subject_type, $subject_id, $file_name, $extension = null)
    {
        if (empty($subject_type) || empty($subject_id) || empty($file_name)) {
            return asset('');
        }

        $subject_name = class_basename($subject_type);
        $path = FileHelper::UPLOAD_PREFIX . '/' . $subject_name . '/' . $subject_id . '/';
        return asset($path . ($extension == null ? $file_name : $file_name . '.' . $extension));
    }
}

if (!function_exists('asset_upload_obj')) {
    function asset_upload_obj($subject, $file_name, $extension = null)
    {
        if (empty($subject) || empty($file_name)) {
            return asset('');
        }

        $subject_name = class_basename($subject);
        $path = FileHelper::UPLOAD_PREFIX . '/' . $subject_name . '/' . $subject['id'] . '/';
        return asset($path . ($extension == null ? $file_name : $file_name . '.' . $extension));
    }
}

if (!function_exists('asset_upload_id')) {
    function asset_upload_id($upload_id)
    {
        $upload = Upload::find($upload_id);
        if ($upload == null) {
            return asset('');
        }

        $subject_name = class_basename($upload->subject_type);
        $path = FileHelper::UPLOAD_PREFIX . '/' . $subject_name . '/' . $upload->subject_id . '/';
        return asset($path . $upload->full_name);
    }
}

if (!function_exists('asset_avatar')) {
    function asset_avatar($pathOrId = null)
    {
        if (empty($pathOrId)) {
            return asset(FileHelper::DEFAULT_AVATAR);
        }
        $type_of_pathOrId = gettype($pathOrId);

        if ($type_of_pathOrId == 'integer' || ($type_of_pathOrId == 'string' && is_int($pathOrId))) {
            $upload = Upload::find($pathOrId);
            if ($upload == null) {
                return asset(FileHelper::DEFAULT_AVATAR);
            }

            $subject_name = class_basename($upload->subject_type);
            return asset(FileHelper::UPLOAD_PREFIX . '/' . $subject_name . '/' . $upload->subject_id . '/' . $upload->full_name);
        }

        return asset($pathOrId);
    }
}

if (!function_exists('changeLang')) {
    function changeLang($lang)
    {
        User::changeLang($lang);
    }
}

if (!function_exists('getErrorMessage')) {
    function getErrorMessage($error)
    {
        if ($error == null) {
            return '';
        } else {
            if (env('APP_DEBUG')) {
                return $error->getMessage() . ' - (File: ' . basename($error->getFile()) . ', Line: ' . $error->getLine() . ')';
            } else {
                return '500 ' . __('Internal server error');
            }
        }
    }
}

if (!function_exists('getRandomColor')) {
    function getRandomColor()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('getRandomColorValue')) {
    function getRandomColorValue()
    {
        $values = [
            [
                'background' => 'light-primary',
                'text' => 'primary',
            ],
            [
                'background' => 'light-info',
                'text' => 'info',
            ],
            [
                'background' => 'light-success',
                'text' => 'success',
            ],
            [
                'background' => 'light-warning',
                'text' => 'warning',
            ],
            [
                'background' => 'light-danger',
                'text' => 'danger',
            ],
        ];

        $random_number = random_int(0, count($values) - 1);
        return $values[$random_number];
    }
}

if (!function_exists('renderInput')) {
    /**
     * @param string $id
     * @param string $label
     * @param string $model
     * @param array $options
     * - key string
     * - type string
     * - name string
     * - change string
     * - required boolean
     * - class string
     * - labelClass string
     * - inputClass string
     * - placeholder string
     * - maxlength integer
     * - min integer
     * - max integer
     * - renderInFile boolean
     */
    function renderInput($id, $model, $label, $options = [])
    {
        return '
            <div class="fv-row mb-5' . (isset($options['class']) ? ' ' . $options['class'] : '') . '" ' . (isset($options['key']) ? 'wire:key="' . $options['key'] . '"' : '') . '>
                <label for="' . $id . '"
                    class="d-flex align-items-center fs-5 fw-semibold mb-2' . (isset($options['labelClass']) ? ' ' . $options['labelClass'] : '') . '">
                    <span
                        class="' . (isset($options['required']) && ($options['required'] == true || $options['required'] == 'true') ? 'required' : '') . '">' . (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __("' . $label . '") }}' : $label) . '</span>
                </label>

                <input type="' . (isset($options['type']) ? $options['type'] : 'text') . '" class="form-control form-control-lg form-control-solid' . (isset($options['inputClass']) ? $options['inputClass'] : '') . '"
                    id="' . $id . '" ' . (isset($options['name']) ? 'name="' . $options['name'] . '"' : '') . ' ' . (isset($options['placeholder']) ? 'placeholder="' . $options['placeholder'] . '"' : '') . ' ' . (isset($options['maxlength']) ? 'maxlength="' . $options['maxlength'] . '"' : '') . ' ' . (isset($options['min']) ? 'min="' . $options['min'] . '"' : '') . ' ' . (isset($options['max']) ? 'max="' . $options['max'] . '"' : '') . ' wire:model.lazy="' . $model . '"
                    ' . (isset($options['change']) ? 'wire:change="' . $options['change'] . '"' : '') . ' />
            </div>
        ';
    }
}

if (!function_exists('renderTextarea')) {
    /**
     * @param string $id
     * @param string $label
     * @param string $model
     * @param array $options
     * - key string
     * - name string
     * - change string
     * - required boolean
     * - rows integer
     * - cols integer
     * - class string
     * - labelClass string
     * - inputClass string
     * - renderInFile boolean
     */
    function renderTextarea($id, $model, $label, $options = [])
    {
        return '
            <div class="fv-row mb-5' . (isset($options['class']) ? ' ' . $options['class'] : '') . '" ' . (isset($options['key']) ? 'wire:key="' . $options['key'] . '"' : '') . '>
                <label for="' . $id . '"
                    class="d-flex align-items-center fs-5 fw-semibold mb-2' . (isset($options['labelClass']) ? ' ' . $options['labelClass'] : '') . '">
                    <span
                        class="' . (isset($options['required']) && ($options['required'] == true || $options['required'] == 'true') ? 'required' : '') . '">' . (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __("' . $label . '") }}' : $label) . '</span>
                </label>

                <textarea class="form-control form-control-lg form-control-solid' . (isset($options['inputClass']) ? $options['inputClass'] : '') . '"
                    id="' . $id . '" ' . (isset($options['name']) ? 'name="' . $options['name'] . '"' : '') . ' rows="' . (isset($options['rows']) ? $options['rows'] : '6') . '" ' . (isset($options['cols']) ? 'cols="' . $options['cols'] . '"' : '') . ' wire:model.lazy="' . $model . '"
                    ' . (isset($options['change']) ? 'wire:change="' . $options['change'] . '"' : '') . '></textarea>
            </div>
        ';
    }
}

if (!function_exists('renderSelect')) {
    /**
     * @param string $id
     * @param string $label
     * @param string $model
     * @param array $data
     * @param array $options
     * - key string
     * - name string
     * - change string
     * - multiple boolean
     * - required boolean
     * - class string
     * - labelClass string
     * - selectClass string
     * - placeholder string
     * - dataValue string
     * - dataText string
     * - select2 boolean
     * - ignore boolean
     * - renderInFile boolean
     */
    function renderSelect($id, $model, $label, $data, $options = [])
    {
        $selectOptions = '<option>' . (isset($options['placeholder']) ? $options['placeholder'] : 'Select') . '</option>';

        foreach ($data as $dt) {
            $selectOptions .= '<option value="' . $dt[(isset($options['dataValue']) ? $options['dataValue'] : 'id')] . '">' . $dt[(isset($options['dataText']) ? $options['dataText'] : 'text')] . '</option>';
        }

        return '
            <div class="fv-row mb-5' . (isset($options['class']) ? ' ' . $options['class'] : '') . '" ' . (isset($options['key']) ? 'wire:key="' . $options['key'] . '"' : '') . ' ' . ((!isset($options['select2']) || $options['select2'] == true || $options['select2'] == 'true') && (!isset($options['ignore']) || $options['ignore'] == true || $options['ignore'] == 'true') ? 'wire:ignore' : '') . '>
                <label for="' . $id . '"
                    class="d-flex align-items-center fs-5 fw-semibold mb-2' . (isset($options['labelClass']) ? ' ' . $options['labelClass'] : '') . '">
                    <span
                        class="' . (isset($options['required']) && ($options['required'] == true || $options['required'] == 'true') ? 'required' : '') . '">' . (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __("' . $label . '") }}' : $label) . '</span>
                </label>

                <select class="form-select ' . (!isset($options['select2']) || $options['select2'] == true || $options['select2'] == 'true' ? 'select-2-dropdown' : '') . '' . (isset($options['selectClass']) ? $options['selectClass'] : '') . '" id="' . $id . '" ' . (isset($options['name']) ? 'name="' . $options['name'] . '"' : '') . ' ' . (!isset($options['ignore']) || $options['ignore'] == true || $options['ignore'] == 'true' ? 'ignored="true"' : 'ignored="false"') . '
                    ' . (isset($options['placeholder']) ? 'placeholder="' . $options['placeholder'] . '"' : '') . ' ' . (isset($options['multiple']) && ($options['multiple'] == true || $options['multiple'] == 'true') ? 'multiple="' . $options['multiple'] . '"' : '') . ' wire:model="' . $model . '" ' . (isset($options['change']) ? 'wire:change="' . $options['change'] . '"' : '') . '>
                    ' . $selectOptions . '
                </select>
            </div>
        ';
    }
}

if (!function_exists('renderSwitch')) {
    /**
     * @param string $id
     * @param string $label
     * @param string $model
     * @param array $options
     * - key string
     * - name string
     * - change string
     * - class string
     * - labelClass string
     * - inputClass string
     * - startWithLabel boolean
     * - renderInFile boolean
     */
    function renderSwitch($id, $model, $label, $options = [])
    {
        $startWithLabelExist = isset($options['startWithLabel']) && ($options['startWithLabel'] == true || $options['startWithLabel'] == 'true');
        $label = '<label class="form-check-label' . (isset($options['labelClass']) ? ' ' . $options['labelClass'] : '') . '' . ($startWithLabelExist ? ' me-2' : '') . '" for="' . $id . '">
            ' . (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __("' . $label . '") }}' : $label) . '
        </label>';

        return '
            <div class="form-check form-switch form-check-custom form-check-solid mb-5' . (isset($options['class']) ? ' ' . $options['class'] : '') . '" ' . (isset($options['key']) ? 'wire:key="' . $options['key'] . '"' : '') . '>
                ' . ($startWithLabelExist ? $label : '') . '
                <input class="form-check-input' . (isset($options['inputClass']) ? $options['inputClass'] : '') . '" type="checkbox" id="' . $id . '" ' . (isset($options['name']) ? 'name="' . $options['name'] . '"' : '') . '
                    wire:model="' . $model . '" ' . (isset($options['change']) ? 'wire:change="' . $options['change'] . '"' : '') . ' />
                ' . ($startWithLabelExist ? '' : $label) . '
            </div>
        ';
    }
}

if (!function_exists('renderCheckbox')) {
    /**
     * @param string $id
     * @param string $label
     * @param string $model
     * @param array $options
     * - key string
     * - name string
     * - change string
     * - class string
     * - labelClass string
     * - inputClass string
     * - labelVariable boolean
     * - renderInFile boolean
     */
    function renderCheckbox($id, $model, $label, $options = [])
    {
        if (isset($options['labelVariable']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true')) {
            $label_result = (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __(' . $label . ') }}' : $label);
        } else {
            $label_result = (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __("' . $label . '") }}' : $label);
        }

        return '
            <div class="form-check mb-5' . (isset($options['class']) ? ' ' . $options['class'] : '') . '" ' . (isset($options['key']) ? 'wire:key="' . $options['key'] . '"' : '') . '>
                <input class="form-check-input' . (isset($options['inputClass']) ? $options['inputClass'] : '') . '" type="checkbox" id="' . $id . '" ' . (isset($options['name']) ? 'name="' . $options['name'] . '"' : '') . '
                    ' . (isset($options['value']) ? 'value="' . $options['value'] . '"' : '') . ' wire:model="' . $model . '" ' . (isset($options['change']) ? 'wire:change="' . $options['change'] . '"' : '') . ' />
                <label class="form-check-label' . (isset($options['labelClass']) ? ' ' . $options['labelClass'] : '') . '" for="' . $id . '">
                    ' . $label_result . '
                </label>
            </div>
        ';
    }
}

if (!function_exists('renderRadio')) {
    /**
     * @param string $id
     * @param string $label
     * @param string $model
     * @param array $options
     * - key string
     * - name string
     * - change string
     * - class string
     * - labelClass string
     * - inputClass string
     * - labelVariable boolean
     * - renderInFile boolean
     */
    function renderRadio($id, $model, $label, $options = [])
    {
        if (isset($options['labelVariable']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true')) {
            $label_result = (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __(' . $label . ') }}' : $label);
        } else {
            $label_result = (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __("' . $label . '") }}' : $label);
        }

        return '
            <div class="form-check form-check-custom form-check-solid mb-5' . (isset($options['class']) ? ' ' . $options['class'] : '') . '" ' . (isset($options['key']) ? 'wire:key="' . $options['key'] . '"' : '') . '>
                <input class="form-check-input' . (isset($options['inputClass']) ? $options['inputClass'] : '') . '" type="radio" id="' . $id . '" ' . (isset($options['name']) ? 'name="' . $options['name'] . '"' : '') . '
                    ' . (isset($options['value']) ? 'value="' . $options['value'] . '"' : '') . ' wire:model="' . $model . '" ' . (isset($options['change']) ? 'wire:change="' . $options['change'] . '"' : '') . ' />
                <label class="form-check-label' . (isset($options['labelClass']) ? ' ' . $options['labelClass'] : '') . '" for="' . $id . '">
                    ' . $label_result . '
                </label>
            </div>
        ';
    }
}

if (!function_exists('renderRange')) {
    /**
     * @param string $id
     * @param string $label
     * @param string $model
     * @param array $options
     * - key string
     * - name string
     * - change string
     * - class string
     * - labelClass string
     * - inputClass string
     * - renderInFile boolean
     */
    function renderRange($id, $model, $label = null, $options = [])
    {
        $string = '<div ' . (isset($options['class']) ? 'class="' . $options['class'] . '"' : '') . ' ' . (isset($options['key']) ? 'wire:key="' . $options['key'] . '"' : '') . '>';

        if (!empty($label)) {
            $string .= '<label for="' . $id . '" ' . (isset($options['labelClass']) ? 'class="' . $options['labelClass'] . '"' : '') . '>' . (isset($options['renderInFile']) && ($options['renderInFile'] == true || $options['renderInFile'] == 'true') ? '{{ __("' . $label . '") }}' : $label) . '</label>';
        }

        $string .= '<input type="range" class="form-range' . (isset($options['inputClass']) ? $options['inputClass'] : '') . '" id="' . $id . '" ' . (isset($options['name']) ? 'name="' . $options['name'] . '"' : '') . '
            wire:model="' . $model . '" ' . (isset($options['change']) ? 'wire:change="' . $options['change'] . '"' : '') . ' />
        </div>';
        return $string;
    }
}
