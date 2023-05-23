<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSetting extends Model
{
    use HasFactory;
    protected $table = 'project_settings';

    const RERPORT = 1;
    const CHART = 2;
    const FILTER = 3;
    const FORM = 4;
    const NUMBERING = 5;
    const BARCODE = 6;
    const DROPDOWN = 7;

    public static function _delete_by_module($module_id)
    {
        self::where('app_module_id', $module_id)->delete();
    }

    public function get_types()
    {
        return [
            [
                'id' => self::RERPORT,
                'value' => 'Report',
            ],
            [
                'id' => self::CHART,
                'value' => 'Chart',
            ],
            [
                'id' => self::FILTER,
                'value' => 'Filter',
            ],
            [
                'id' => self::FORM,
                'value' => 'Form',
            ],
            [
                'id' => self::NUMBERING,
                'value' => 'Numbering',
            ],
            [
                'id' => self::BARCODE,
                'value' => 'Barcode',
            ],
            [
                'id' => self::DROPDOWN,
                'value' => 'Dropdown',
            ],
        ];
    }
}
