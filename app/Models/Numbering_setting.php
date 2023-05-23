<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numbering_setting extends Model
{
    use HasFactory;

    public static function _delete($id)
    {
        Numbering_assignment::where('numbering_setting_id', $id)->delete();
        Barcode_assignment::where('numbering_setting_id', $id)->delete();
        self::where('id', $id)->delete();
    }

    public static function _delete_by_module($module_id)
    {
        $numbering_setting = self::where('app_module_id', $module_id)->first();

        if ($numbering_setting != null)
            self::_delete($numbering_setting->id);
    }

    // relations
    public function numberAssignments()
    {
        return $this->hasMany(Numbering_assignment::class);
    }

    public function barcodeAssignments()
    {
        return $this->hasMany(Barcode_assignment::class);
    }

    public function created_by()
    {
        return $this->hasOne(User::class);
    }
}
