<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function _save($data, $id = null)
    {
        $model = ($id == null ? new self : self::find($id));
        $model->fill($data);
        return $model->save();
    }

    public static function _read($id, $bool = true)
    {
        $model = self::find($id);
        $model->read = $bool;
        return $model->save();
    }

    public static function _delete($id)
    {
        $menu = self::find($id);

        if ($menu->category == 'dropdown')
            return self::where('source', $id)->delete() && $menu->delete();
        else
            return $menu->delete();
    }

    public function userPermission()
    {
        return $this->hasMany(UserPermission::class, 'notification_id');
    }
}
