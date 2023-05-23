<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public static function getPermissionByPseudo($pseudo_name, $field = null)
    {
        if ($field == null) {
            return self::where('pseudo_name', $pseudo_name)->first();
        } else {
            return self::where('pseudo_name', $pseudo_name)->first()->$field ?? null;
        }
    }

    public static function _delete_by_module($module_id)
    {
        self::where('app_module_id', $module_id)->delete();
    }

    // public function appModule()
    // {
    //     return $this->hasOne(AppModule::class);
    // }
    public function module()
    {
        return $this->belongsTo(AppModule::class, 'app_module_id');
    }
    public function userPermission()
    {
        return $this->hasMany(UserPermission::class, 'permission_id');
    }
    public function rolePermission()
    {
        return $this->hasMany(RolePermission::class, 'permission_id');
    }
    // }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
