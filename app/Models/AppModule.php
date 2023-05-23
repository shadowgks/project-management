<?php

namespace App\Models;

use App\Helpers\ModelHelper;
use File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Schema;

class AppModule extends Model
{
    use HasFactory;

    public static function _get($id = null)
    {
        if ($id == null) {
            return self::where('active', true)->orderBy('name')->get();
        } else {
            return self::where('id', $id)->first();
        }
    }

    public static function _delete($id)
    {
        $module = self::find($id);
        $path = base_path('Modules/' . $module->name);

        $module_table = null;
        if (File::exists(base_path('Modules/' . $module->name))) {
            $module_table = ModelHelper::getTableNameByModule($id);

            if ($module_table != null) {
                Schema::dropIfExists($module_table);
            }
        }

        if (File::exists($path)) {
            File::deleteDirectory($path);
        }

        // NOTE - Includes
        Numbering_setting::_delete_by_module($id);
        DropDown::_delete_by_module($id);
        Form::_delete_by_module($id);
        Validation::_delete_by_module($id);
        Status::_delete_by_module($id);
        Menu::_delete_by_module($module->name);
        ProjectSetting::_delete_by_module($id);
        Permission::_delete_by_module($id);
        Upload::_delete_by_module($id);
        Comment::_delete_by_module($id);
        Reminder::_delete_by_module($id);

        // NOTE - Done
        $module->delete();
    }

    // Relations

    public function created_by()
    {
        return $this->hasOne(User::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    public function permission()
    {
        return $this->hasMany(Permission::class, 'app_module_id');
    }
    public function dropdowns()
    {
        return $this->hasMany(Drop_down::class);
    }
    public function validation()
    {
        return $this->hasOne(Drop_down::class);
    }
}
