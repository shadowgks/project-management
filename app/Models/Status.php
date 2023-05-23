<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    public static function _delete($id)
    {
        self::where('id', $id)->delete();
    }

    public static function _delete_by_module($module_id)
    {
        self::where('app_module_id', $module_id)->delete();
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
