<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropDown extends Model
{
    use HasFactory;
    protected $table = 'drop_downs';
    protected $guarded = [];

    public static function save_many($options, $data)
    {
        try {
            DB::beginTransaction();
            $saved_options = [];

            // dd($options);
            foreach ($options as $option) {
                $model = (empty($option['saved_id']) ? new self : self::find($option['saved_id']));
                $model->select_field = $data['column'];
                $model->select_id = $option['id'];
                $model->select_value = $option['value'];
                $model->app_module_id = $data['module'];
                $model->user_id = Auth::id();
                $model->save();
                array_push($saved_options, $model->id);
            }

            $all_dropdowns = self::where('select_field', $data['column'])->where('app_module_id', $data['module'])->get();

            foreach ($all_dropdowns as $dropdown) {
                if (!in_array($dropdown->id, $saved_options)) {
                    $dropdown->delete();
                }
            }

            DB::commit();
            return [
                'success' => true,
                'saved_options' => $saved_options,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false
            ];
        }
    }

    public static function delete_many($data)
    {
        try {
            DB::beginTransaction();
            self::where('select_field', $data['column'])->where('app_module_id', $data['module'])->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function _save($data, $id = null)
    {
        if ($id == null)
            $dropdown = new self;
        else
            $dropdown = self::find($id);

        $dropdown->fill($data);
        $dropdown->user_id = Auth::id();
        $dropdown->save();
    }

    public static function save_field($field, $module_id)
    {
        $return = [
            'table' => $field['table'],
            'column' => $field['column'],
            'saved' => [],
        ];

        if ($field['value']['type'] == 'custom') {
            foreach ($field['value']['custom'] as $custom) {
                $dropdown = new self;
                $dropdown->select_table = $field['table_name'];
                $dropdown->select_field = $field['column'];
                $dropdown->select_id = $custom['value'];
                $dropdown->select_value = $custom['text'];
                $dropdown->app_module_id = $module_id;
                $dropdown->user_id = Auth::id();
                $dropdown->save();

                array_push($return['saved'], $dropdown->id);
            }
        }

        return $return;
    }

    public static function save_fields($fields, $module_id)
    {
        foreach ($fields as $field) {
            if (in_array($field['type'], ['select', 'multiple_select', 'radio', 'checkbox'])) {
                self::save_field($field, $module_id);
            }
        }
    }

    public static function _edit_get($select_field, $app_module_id)
    {
        return self::where('select_field', $select_field)->where('app_module_id', $app_module_id)->get();
    }

    public static function _delete($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function _delete_dropdowns($select_field, $app_module_id)
    {
        return self::where('select_field', $select_field)->where('app_module_id', $app_module_id)->delete();
    }

    public static function _delete_by_module($module_id)
    {
        self::where('app_module_id', $module_id)->delete();
    }

    public function appModule()
    {
        return $this->hasOne(AppModule::class);
    }

    /**
     * Get the app_module that owns the DropDown
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app_module()
    {
        return $this->belongsTo(AppModule::class);
    }
}
