<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;

    protected $table = 'validation_settings';

    public static function _delete($id)
    {
        ValidationStep::where('validation_id', $id)->delete();
        self::where('id', $id)->delete();
    }

    public static function _delete_by_module($module_id)
    {
        $validation = self::where('app_module_id', $module_id)->first();

        if ($validation != null)
            self::_delete($validation->id);
    }

    public function appModule()
    {
        return $this->hasOne(AppModule::class);
    }
    public function created_by()
    {
        return $this->hasOne(User::class);
    }
}
