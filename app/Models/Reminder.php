<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function _get($id = null)
    {
        if ($id == null)
            return self::with('created_by')->orderByDesc('id')->get();
        else
            return self::where('id', $id)->with('created_by')->first();
    }

    public static function _get_by_module($app_module_id, $row_id = null)
    {
        $comments = self::where('app_module_id', $app_module_id);

        if ($row_id != null) {
            $comments = $comments->where('rel_id', $row_id);
        }

        return $comments->with('created_by')->orderByDesc('id')->get();
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

    public static function _delete($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function _delete_by_module($module_id)
    {
        self::where('app_module_id', $module_id)->delete();
    }

    public function appModule()
    {
        return $this->hasOne(AppModule::class);
    }

    public function user_to()
    {
        return $this->hasOne(User::class, 'id', 'user_to_notify');
    }

    public function created_by()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
