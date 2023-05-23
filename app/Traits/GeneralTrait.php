<?php

namespace App\Traits;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;
use PDF;
use Qoraiche\MailEclipse\MailEclipse;

trait GeneralTrait
{
// Generate a number for a specific type, the date is optional if you have chosen to use today's date
    public function get_numbering($module_id, $date = '')
    {
        $rel_type = get_fields_by_key($module_id, 'id', 'app_modules', 'name');
        $reference_id = get_fields_by_key($module_id, 'app_module_id', 'numbering_settings', 'id');
        $number = '';
        $data = DB::table('numbering_assignments')
            ->where('numbering_setting_id', $reference_id)
            ->first();

        // $data=Numbering_setting::find($reference_id)->numberAssign;

        if ($data->use_today_date) {
            $date = date("Y-m-d");
        }

        $elements = json_decode($data->elements);

        $elements = collect($elements)->sortBy('order')->toArray();
        foreach ($elements as $element) {
            if ($element->type == 'number') {
                $number_value = '';
                if (!$data->random) {
                    $number_value = $this->get_number_value($reference_id, $date);
                }

                if ($data->random) {
                    $number_value = $this->generate_unique_number('numbering_assignments', $rel_type);
                }

                $prefix = $number_value;
            }
            if ($element->type == 'date') {
                $prefix = $this->number_filter($element->value, $date);
            }

            if ($element->type == 'static') {
                $prefix = $element->value;
            }

            $number .= $prefix;
        }

        return $number;
    }

    // Get from the table number_length the number of digits to use to format the generated number
    public function get_number_length($table, $rel_type)
    {
        $module_id = get_fields_by_key($rel_type, 'name', 'app_modules', 'id');
        $reference_id = get_fields_by_key($module_id, 'app_module_id', 'numbering_settings', 'id');
        $number_length = get_fields_by_key($reference_id, 'numbering_setting_id', $table, 'number_length');

        return $number_length;
    }

    // Generate a unique random number for a specific type, this function will be used in case of random numbering
    public function generate_unique_number($table, $rel_type)
    {
        $numbers_array = [];
        $data = DB::table($rel_type)->get();

        foreach ($data as $row) {
            array_push($numbers_array, get_module_code($table, $rel_type, $row->id));
        }

        $number_length = $this->get_number_length($table, $rel_type);
        $end_number = str_pad(9, $number_length, 0);

        do {
            $number = random_int(1, $end_number);

        } while (in_array($number, $numbers_array));

        $number = str_pad($number, $number_length, 0, 0);

        return $number;
    }

    // get the next number to use from the table number_trackings
    public function get_next_number($reference_id, $year, $month, $week, $day)
    {
        $data = DB::table('numbering_trackings')
            ->where('numbering_setting_id', $reference_id)
            ->where('year', $year)
            ->where('month', $month)
            ->where('week', $week)
            ->where('day', $day)
            ->first()->number;

        return $data;
    }

    // get the number to use in the ordered numbering taking into account the numbering by year, by month, by week or by day
    public function get_number_value($reference_id, $date)
    {

        $parse_date = Carbon::parse($date);

        $number = '';
        $data = DB::table('numbering_assignments')
            ->where('numbering_setting_id', $reference_id)
            ->first();
        $numbering_per_periode = json_decode($data->numbering_per_periode)[0];
        $elements = json_decode($data->elements);
        foreach ($elements as $element) {
            if ($element->type == 'number') {
                $initial_number = $element->value;
            }

        }

        $year = ($numbering_per_periode->year || $numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day ) ? date('Y', strtotime($date)) : 0;
        $month = ($numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day) ? date('m', strtotime($date)) : 0;
        $week = ($numbering_per_periode->week) ? $parse_date->weekNumberInMonth : 0;
        $day = ($numbering_per_periode->day) ? date('d', strtotime($date)) : 0;

        $year_result = $this->check_year_numbering('numbering_trackings', $reference_id, $year);

        if ($year_result >= 1) {
            $month_result = $this->check_month_numbering('numbering_trackings', $reference_id, $year, $month);
            if ($month_result == 0) {
                DB::table('numbering_trackings')->insert([
                    'numbering_setting_id' => $reference_id,
                    'month' => $month,
                    'year' => $year,
                    'week' => $week,
                    'day' => $day,
                    'number' => $initial_number,
                    'user_id' => Auth::id(),

                ]);
            } else {

                $week_result = $this->check_week_numbering('numbering_trackings', $reference_id, $year, $month, $week);
                if ($week_result == 0) {
                    DB::table('numbering_trackings')->insert([
                        'numbering_setting_id' => $reference_id,
                        'month' => $month,
                        'year' => $year,
                        'week' => $week,
                        'day' => $day,
                        'number' => $initial_number,
                        'user_id' => Auth::id(),

                    ]);
                }

                $day_result = $this->check_day_numbering('numbering_trackings', $reference_id, $year, $month, $week, $day);
                if ($day_result == 0) {
                    DB::table('numbering_trackings')->insert([
                        'numbering_setting_id' => $reference_id,
                        'month' => $month,
                        'year' => $year,
                        'week' => $week,
                        'day' => $day,
                        'number' => $initial_number,
                        'user_id' => Auth::id(),

                    ]);
                }

            }

        } else {
            DB::table('numbering_trackings')->insert([
                'numbering_setting_id' => $reference_id,
                'month' => $month,
                'year' => $year,
                'week' => $week,
                'day' => $day,
                'number' => $initial_number,
                'user_id' => Auth::id(),

            ]);

        }

        $next_number = $this->get_next_number($reference_id, $year, $month, $week, $day);

        $number_length = $data->number_length;
        return str_pad($next_number, $number_length, '0', STR_PAD_LEFT);
    }

    // update the number related to the specific type, this update will only be done in the case of ordered numbering
    public function update_assignement_number($module_id, $date = '')
    {
        // $module_id = get_fields_by_key($rel_type, 'name', 'app_modules', 'id');
        $reference_id = get_fields_by_key($module_id, 'app_module_id', 'numbering_settings', 'id');

        $res = DB::table('numbering_assignments')
            ->where('numbering_setting_id', $reference_id)
            ->first();

        if (!$res->random) {
            $numbering_per_periode = json_decode($res->numbering_per_periode)[0];
            if ($res->use_today_date) {
                $date = date("Y-m-d");
            }
            $parse_date = Carbon::parse($date);

            $year = ($numbering_per_periode->year || $numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day ) ? date('Y', strtotime($date)) : 0;
            $month = ($numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day) ? date('m', strtotime($date)) : 0;
            $week = ($numbering_per_periode->week) ? $parse_date->weekNumberInMonth : 0;
            $day = ($numbering_per_periode->day) ? date('d', strtotime($date)) : 0;

            $number = $this->get_next_number($reference_id, $year, $month, $week, $day);
            $new_number = $number + 1;

            DB::table('numbering_trackings')
                ->where('numbering_setting_id', $reference_id)
                ->where('year', $year)
                ->where('month', $month)
                ->where('week', $week)
                ->where('day', $day)
                ->update(['number' => $new_number]);
        }

    }

    public function number_filter($res, $date)
    {

        if ($res == 'Y' || $res == 'y' || $res == 'm' || $res == 'd') {
            return date($res, strtotime($date));
        }
    }

    public function check_year_numbering($table, $reference_id, $year)
    {

        return $data = DB::table($table)
            ->where('numbering_setting_id', $reference_id)
            ->where('year', $year)
            ->count();

    }

    public function check_month_numbering($table, $reference_id, $year, $month)
    {

        return $data = DB::table($table)
            ->where('numbering_setting_id', $reference_id)
            ->where('year', $year)
            ->where('month', $month)
            ->count();

    }

    public function check_week_numbering($table, $reference_id, $year, $month, $week)
    {

        return $data = DB::table($table)
            ->where('numbering_setting_id', $reference_id)
            ->where('year', $year)
            ->where('month', $month)
            ->where('week', $week)
            ->count();

    }

    public function check_day_numbering($table, $reference_id, $year, $month, $week, $day)
    {

        return $data = DB::table($table)
            ->where('numbering_setting_id', $reference_id)
            ->where('year', $year)
            ->where('month', $month)
            ->where('week', $week)
            ->where('day', $day)
            ->count();

    }

    //  check if the model has validation
    public function model_has_validation($model)
    {

        $data = DB::table('validation_settings')
            ->where('app_module_id', $model)
            ->count();

        if ($data > 0) {
            return 1;
        }

        return 0;

    }

    //  get the validation steps, this function returns an array with one row containing the next validation in case of require order or an array of all remaining validation in the opposite case
    public function get_validation_steps($module_id)
    {
        // $module_id = get_fields_by_key($rel_type, 'name', 'app_modules', 'id');

        $validation = DB::table('validation_settings')
            ->where('app_module_id', $module_id)
            ->first();

        $data = DB::table('validation_steps')
            ->where('validation_id', $validation->id)
            ->get();
        // $data = Validation::find($validation->id)->validationStep;

        $validation_steps = [];

        foreach ($data as $d) {
            $validation_id = get_fields_by_key($d->id, 'validation_step_id', 'validation_recordings', 'id');
            if (!$validation_id) {
                $step['id'] = $d->id;
                $step['step_order'] = $d->step_order;
                $step['name'] = $d->name;
                $step['status_id'] = $d->status_id;
                $step['permission_id'] = $d->permission_id;

                array_push($validation_steps, $step);

            }

        }

        if ($validation->require_order) {
            $first_validation = [];
            $validation_steps = collect($validation_steps)->sortBy('step_order')->toArray();

            foreach ($validation_steps as $step) {
                array_push($first_validation, $step);
                break;
            }

            $validation_steps = [];
            $validation_steps = $first_validation;
        }

        $steps = [];
        foreach ($validation_steps as $step) {
            $permission = DB::table('user_permissions')
                ->where('permission_id', $step['permission_id'])
                ->where('user_id', Auth::id())
                ->first();

            if ($permission and $permission->value == 'true') {
                array_push($steps, $step);
            }

        }

        return $steps;

    }

    public function save_validation_recordings($module_id, $rel_id, $validation_step_id, $comment = '')
    {
        // validation steps for module
        // current step of related id
        // check of order +
        // has_permission_by_id('');

        //$module_id = get_fields_by_key($rel_type, 'name', 'app_modules', 'id');
        $rel_type = get_fields_by_key($module_id, 'id', 'app_modules', 'name');
        $status = get_fields_by_key($validation_step_id, 'id', 'validation_steps', 'status_id');
        $success = 0;

        $validation = DB::table('validation_settings')
            ->where('app_module_id', $module_id)
            ->first();

        if ($validation->require_order) {
            $step = $this->get_validation_steps($module_id);
            if ($step) {
                if ($step[0]['id'] != $validation_step_id) {
                    return 0;
                }

            } else {
                return 0;
            }

        }

        $validation_recording = DB::table('validation_recordings')
            ->where('app_module_id', $module_id)
            ->where('rel_id', $rel_id)
            ->where('validation_step_id', $validation_step_id)
            ->first();

        if (!$validation_recording) {
            $success = DB::table($rel_type)
                ->where('id', $rel_id)
                ->update(['status_id' => $status]);

            if ($success) {
                $success = DB::table('validation_recordings')->insert([
                    'app_module_id' => $module_id,
                    'rel_id' => $rel_id,
                    'comment' => $comment,
                    'user_id' => Auth::id(),
                    'validation_step_id' => $validation_step_id,
                ]);
            }

        }

        return $success;

    }

    public function get_mail_template($template_slug, $module_id)
    {

        $template_name = ucfirst($template_slug . 'Mail');

        $templateData = MailEclipse::getMailableTemplateData($template_name);

        $message = $templateData['template'];
        $fields = get_merge_fields('test',$module_id, 'templates_slug', $template_slug);

        foreach ($fields as $field) {
            $key = '{{ $' . $field['key'] . ' }}';

            $message = str_replace($key, $field['value'], $message);
        }

        return $message;

    }

    public function get_barcode($module_id, $date = '')
    {
        $rel_type = get_fields_by_key($module_id, 'id', 'app_modules', 'name');
        $reference_id = get_fields_by_key($module_id, 'app_module_id', 'numbering_settings', 'id');
        $number = '';
        $data = DB::table('barcode_assignments')
            ->where('numbering_setting_id', $reference_id)
            ->first();

        // $data=Numbering_setting::find($reference_id)->numberAssign;

        if ($data->use_today_date) {
            $date = date("Y-m-d");
        }

        $elements = json_decode($data->elements);

        $elements = collect($elements)->sortBy('order')->toArray();
        foreach ($elements as $element) {
            if ($element->type == 'number') {
                $number_value = '';
                if (!$data->random) {
                    $number_value = $this->get_barcode_number_value($reference_id, $date);
                }

                if ($data->random) {
                    $number_value = $this->generate_unique_number('barcode_assignments', $rel_type);
                }

                $prefix = $number_value;
            }
            if ($element->type == 'date') {
                $prefix = $this->number_filter($element->value, $date);
            }

            if ($element->type == 'static') {
                $prefix = $element->value;
            }

            $number .= $prefix;
        }

        //  return $number;
        return Hash::make($number);
    }

    public function get_barcode_number_value($reference_id, $date)
    {

        $parse_date = Carbon::parse($date);

        $number = '';
        $data = DB::table('barcode_assignments')
            ->where('numbering_setting_id', $reference_id)
            ->first();
        $numbering_per_periode = json_decode($data->numbering_per_periode)[0];
        $elements = json_decode($data->elements);
        foreach ($elements as $element) {
            if ($element->type == 'number') {
                $initial_number = $element->value;
            }

        }

        $year = ($numbering_per_periode->year || $numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day ) ? date('Y', strtotime($date)) : 0;
        $month = ($numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day) ? date('m', strtotime($date)) : 0;
        $week = ($numbering_per_periode->week) ? $parse_date->weekNumberInMonth : 0;
        $day = ($numbering_per_periode->day) ? date('d', strtotime($date)) : 0;

        $year_result = $this->check_year_numbering('barcode_trackings', $reference_id, $year);

        if ($year_result >= 1) {
            $month_result = $this->check_month_numbering('barcode_trackings', $reference_id, $year, $month);
            if ($month_result == 0) {
                DB::table('barcode_trackings')->insert([
                    'numbering_setting_id' => $reference_id,
                    'month' => $month,
                    'year' => $year,
                    'week' => $week,
                    'day' => $day,
                    'number' => $initial_number,
                    'user_id' => Auth::id(),

                ]);
            } else {

                $week_result = $this->check_week_numbering('barcode_trackings', $reference_id, $year, $month, $week);
                if ($week_result == 0) {
                    DB::table('barcode_trackings')->insert([
                        'numbering_setting_id' => $reference_id,
                        'month' => $month,
                        'year' => $year,
                        'week' => $week,
                        'day' => $day,
                        'number' => $initial_number,
                        'user_id' => Auth::id(),

                    ]);
                }

                $day_result = $this->check_day_numbering('barcode_trackings', $reference_id, $year, $month, $week, $day);
                if ($day_result == 0) {
                    DB::table('barcode_trackings')->insert([
                        'numbering_setting_id' => $reference_id,
                        'month' => $month,
                        'year' => $year,
                        'week' => $week,
                        'day' => $day,
                        'number' => $initial_number,
                        'user_id' => Auth::id(),

                    ]);
                }

            }

        } else {
            DB::table('barcode_trackings')->insert([
                'numbering_setting_id' => $reference_id,
                'month' => $month,
                'year' => $year,
                'week' => $week,
                'day' => $day,
                'number' => $initial_number,
                'user_id' => Auth::id(),

            ]);

        }

        $next_number = $this->get_barcode_next_number($reference_id, $year, $month, $week, $day);

        $number_length = $data->number_length;
        return str_pad($next_number, $number_length, '0', STR_PAD_LEFT);
    }

    public function get_barcode_next_number($reference_id, $year, $month, $week, $day)
    {
        $data = DB::table('barcode_trackings')
            ->where('numbering_setting_id', $reference_id)
            ->where('year', $year)
            ->where('month', $month)
            ->where('week', $week)
            ->where('day', $day)
            ->first()->number;

        return $data;
    }

    public function update_barcode_assignement_number($module_id, $date = '')
    {
        // $module_id = get_fields_by_key($rel_type, 'name', 'app_modules', 'id');
        $reference_id = get_fields_by_key($module_id, 'app_module_id', 'numbering_settings', 'id');

        $res = DB::table('barcode_assignments')
            ->where('numbering_setting_id', $reference_id)
            ->first();

        if (!$res->random) {
            $numbering_per_periode = json_decode($res->numbering_per_periode)[0];
            if ($res->use_today_date) {
                $date = date("Y-m-d");
            }
            $parse_date = Carbon::parse($date);
            $year = ($numbering_per_periode->year || $numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day ) ? date('Y', strtotime($date)) : 0;
            $month = ($numbering_per_periode->month || $numbering_per_periode->week || $numbering_per_periode->day) ? date('m', strtotime($date)) : 0;
            $week = ($numbering_per_periode->week) ? $parse_date->weekNumberInMonth : 0;
            $day = ($numbering_per_periode->day) ? date('d', strtotime($date)) : 0;

            $number = $this->get_barcode_next_number($reference_id, $year, $month, $week, $day);
            $new_number = $number + 1;

            DB::table('barcode_trackings')
                ->where('numbering_setting_id', $reference_id)
                ->where('year', $year)
                ->where('month', $month)
                ->where('week', $week)
                ->where('day', $day)
                ->update(['number' => $new_number]);
        }

    }


}
