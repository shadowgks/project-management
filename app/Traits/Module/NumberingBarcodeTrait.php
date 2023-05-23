<?php

namespace App\Traits\Module;

use App\Models\Barcode_assignment;
use App\Models\Numbering_assignment;
use App\Models\ProjectSetting;
use Auth;
use DB;

trait NumberingBarcodeTrait
{
    public function saveNumberingData($name, $data, $id = '', $callback = null)
    {
        try {
            DB::beginTransaction();
            $id = $id;

            if ($id == '') {
                $setting = new ProjectSetting();
            } else {
                $setting = ProjectSetting::find($id);
            }

            $setting->type = ProjectSetting::NUMBERING;
            $setting->name = $name;
            $setting->value = serialize([
                'numbering' => $data,
            ]);
            $setting->app_module_id = $data['module_id'];
            $setting->save();
            DB::commit();

            if ($callback != null)
                $callback();
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollback();
        }
    }

    public function saveBarcodeData($name, $data, $id = '', $callback = null)
    {
        try {
            DB::beginTransaction();
            $id = $this->values['id'];

            if ($id == '') {
                $setting = new ProjectSetting();
            } else {
                $setting = ProjectSetting::find($id);
            }

            $setting->type = ProjectSetting::BARCODE;
            $setting->name = $name;
            $setting->value = serialize([
                'barcode' => $data,
            ]);
            $setting->save();
            DB::commit();

            if ($callback != null)
                $callback();
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollback();
        }
    }

    public function setNumbering($numbering_data, $numbering_setting_id, $module_id = null)
    {
        $i = 1;
        $elements = [];

        foreach ($numbering_data['elements'] as $element) {
            if ($element['name'] == 'Number') {
                $element_value['type'] = 'number';
                $element_value['value'] = $numbering_data['number_initiator'] ?? 1;
            } elseif ($element['type'] == 'custom') {
                $element_value['type'] = 'static';
                $element_value['value'] = $element['text'];
            } elseif ($element['type'] == 'standard') {
                $element_value['type'] = 'date';
                $element_value['value'] = $element['value'];
            }

            $element_value['order'] = $i;
            array_push($elements, $element_value);
            $i++;
        }

        $numbering_per_periode = [];
        $periode['year'] = $numbering_data['every-year'];
        $periode['month'] = $numbering_data['every-month'];
        $periode['week'] = $numbering_data['every-week'];
        $periode['day'] = $numbering_data['every-day'];
        array_push($numbering_per_periode, $periode);

        $numbering_assignment['random'] = $numbering_data['random'] == "" ? false : $numbering_data['random'];
        $numbering_assignment['use_today_date'] = $numbering_data['use_today_date'];
        $numbering_assignment['date_field'] = $numbering_data['date_field'];
        $numbering_assignment['number_length'] = $numbering_data['number_length'];

        $numbering_assignment['elements'] = json_encode($elements);
        $numbering_assignment['numbering_per_periode'] = json_encode($numbering_per_periode);
        $numbering_assignment['numbering_setting_id'] = $numbering_setting_id;

        if ($module_id == null) {
            $numbering_assignment['user_id'] = Auth::id();
            Numbering_assignment::insert($numbering_assignment);
        } else {
            Numbering_assignment::where('app_module_id', $module_id)->update($numbering_assignment);
        }
    }

    public function setBarcode($barcode_data, $numbering_setting_id, $module_id = null)
    {
        $i = 1;
        $elements = [];

        foreach ($barcode_data['elements'] as $element) {
            if ($element['name'] == 'Number') {
                $element_value['type'] = 'number';
                $element_value['value'] = $numbering_data['number_initiator'] ?? 1;
            } elseif ($element['type'] == 'custom') {
                $element_value['type'] = 'static';
                $element_value['value'] = $element['text'];
            } elseif ($element['type'] == 'standard') {
                $element_value['type'] = 'date';
                $element_value['value'] = $element['text'];
            }

            $element_value['order'] = $i;
            array_push($elements, $element_value);
            $i++;
        }

        $barcode_per_periode = [];
        $periode['year'] = $barcode_data['every-year'];
        $periode['month'] = $barcode_data['every-month'];
        $periode['week'] = $barcode_data['every-week'];
        $periode['day'] = $barcode_data['every-day'];
        array_push($barcode_per_periode, $periode);

        $barcode_assignment['random'] = $barcode_data['random'] == "" ? false : $barcode_data['random'];
        $barcode_assignment['barcode_type'] = $barcode_data['form']['barcode_type'] == '' ? 'C128' : $barcode_data['form']['barcode_type'];
        $barcode_assignment['use_today_date'] = $barcode_data['use_today_date'];
        $barcode_assignment['date_field'] = $barcode_data['date_field'];
        $barcode_assignment['number_length'] = $barcode_data['number_length'];

        $barcode_assignment['elements'] = json_encode($elements);
        $barcode_assignment['numbering_per_periode'] = json_encode($barcode_per_periode);
        $barcode_assignment['numbering_setting_id'] = $numbering_setting_id;

        if ($module_id == null) {
            $barcode_assignment['user_id'] = Auth::id();
            Barcode_assignment::insert($barcode_assignment);
        } else {
            Barcode_assignment::where('app_module_id', $module_id)->update($barcode_assignment);
        }
    }
}
